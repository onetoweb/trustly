<?php

namespace Onetoweb\Trustly;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleCLient;
use Symfony\Component\HttpFoundation\{Request as HttpRequest, JsonResponse};
use Onetoweb\Trustly\Endpoint\Endpoints;
use Onetoweb\Trustly\Exception\{
    VerificationException,
    VerificationInputException,
    PayloadException,
    PrivateKeyException,
    RequestException
};

/**
 * Trustly Api Client.
 */
#[\AllowDynamicProperties]
class Client
{
    /**
     * Version.
     */
    public const VERSION = '1.1';
    
    /**
     * Base Urls.
     */
    public const URL_TEST = 'https://test.trustly.com/api/1';
    public const URL_LIVE = 'https://api.trustly.com/1';
    
    /**
     * Trustly Certs.
     */
    public const TRUSTLY_CERT_TEST = __DIR__ . '/../cert/test.pem';
    public const TRUSTLY_CERT_LIVE = __DIR__ . '/../cert/live.pem';
    
    /**
     * @var string
     */
    private $privateKey;
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var bool
     */
    private $testModus;
    
    /**
     * @var string
     */
    private $version;
    
    /**
     * @var string
     */
    private $defaultNotificationUrl;
    
    /**
     * @param string $privateKey
     * @param string $username
     * @param string $password
     * @param bool $testModus = true
     * @param string $version = self::VERSION
     * 
     * @throws PrivateKeyException if the private key file does not exist or is not readable
     */
    public function __construct(
        string $privateKey,
        string $username,
        string $password,
        bool $testModus = true,
        string $version = self::VERSION
    ) {
        $this->privateKey = $privateKey;
        $this->username = $username;
        $this->password = $password;
        $this->testModus = $testModus;
        $this->version = $version;
        
        // check private key file
        if (!is_readable($this->privateKey)) {
            throw new PrivateKeyException("the private key file: {$this->privateKey} does not exist or is not readable");
        }
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        foreach (Endpoints::list() as $name => $class) {
            $this->{$name} = new $class($this);
        }
    }
    
    /**
     * @return string $defaultNotificationUrl
     * 
     * @return void
     */
    public function setDefaultNotificationUrl(string $defaultNotificationUrl): void
    {
        $this->defaultNotificationUrl = $defaultNotificationUrl;
    }
    
    /**
     * @return string|null
     */
    public function getDefaultNotificationUrl(): ?string
    {
        return $this->defaultNotificationUrl;
    }
    
    /**
     * @return string
     */
    public function getUrl(): string
    {
        if ($this->testModus) {
            return self::URL_TEST;
        } else {
            return self::URL_LIVE;
        }
    }
    
    /**
     * @return string
     */
    public function getTrustlyCert(): string
    {
        if ($this->testModus) {
            return self::TRUSTLY_CERT_TEST;
        } else {
            return self::TRUSTLY_CERT_LIVE;
        }
    }
    
    /**
     * @param mixed $data
     * 
     * @return string
     */
    public function serializeData($data): string
    {
        $serialized = '';
        
        if (is_array($data)) {
            
            ksort($data);
            
            foreach ($data as $key => $value) {
                
                if (is_numeric($key)) {
                    $serialized .= $this->serializeData($value);
                } else {
                    $serialized .= $key . $this->serializeData($value);
                }
            }
            
        } else {
            return $data;
        }
        
        return $serialized;
    }
    
    /**
     * @param string $method,
     * @param string $uuid
     * @param array $data
     * 
     * @return string
     */
    public function createSignature(string $method, string $uuid, array $data): string
    {
        // serialize data
        $serializedData = $this->serializeData($data);
        
        // build plain text
        $plainText = $method . $uuid . $serializedData;
        
        // get merchant private key
        $merchantPrivateKey = openssl_pkey_get_private(file_get_contents($this->privateKey));
        
        // create signature
        openssl_sign($plainText, $signature, $merchantPrivateKey);
        
        return base64_encode($signature);
    }
    
    /**
     * @param array $responseData
     * 
     * @throws VerificationInputException
     * 
     * @return void
     */
    private function checkVerificationParam(array $responseData): void
    {
        foreach (['method', 'uuid', 'signature', 'data'] as $key) {
            
            if (!array_key_exists($key, $responseData)) {
                
                throw new VerificationInputException("$key not found in response");
            }
        }
    }
    
    /**
     * @param array $responseData
     * @param string &$method = null
     * @param string &$uuid = null
     * @param string &$signature = null
     * @param array &$data = null
     * 
     * @return void
     */
    private function assignVerificationParam(
        array $responseData,
        string &$method = null,
        string &$uuid = null,
        string &$signature = null,
        array &$data = null
    ): void {
        
        $method = $responseData['method'];
        $uuid = $responseData['uuid'];
        $signature = $responseData['signature'];
        $data = $responseData['data'];
    }
    
    /**
     * @param array $json
     * 
     * @throws VerificationException verification has failed or has errors
     * 
     * @return bool
     */
    public function verify(string $method, string $uuid, string $signature, array $data): bool
    {
        // get trustly public key
        $trustlyPublicKey = openssl_get_publickey(file_get_contents($this->getTrustlyCert()));
        
        // build plain text
        $plaintext = $method . $uuid . $this->serializeData($data);
        
        // verify singature
        $result = openssl_verify($plaintext, base64_decode($signature), $trustlyPublicKey);
        
        // check result
        if ($result !== 1) {
            
            if ($result === false) {
                
                throw new VerificationException('verification error');
            }
            
            throw new VerificationException('verification failed');
        }
        
        return true;
    }
    
    /**
     * @param string $method
     * @param Request $request
     * @param array $extraData
     * 
     * @throws PayloadException if neither notification url or default notification url is set
     * 
     * @return array
     */
    public function buildPayload(string $method, Request $request, array $extraData = []): array
    {
        // check notification url
        if (
            $request->getNotificationUrl() === null
            and $this->getDefaultNotificationUrl() === null
        ) {
            throw new PayloadException('either a notification url or a default notification url is required');
        }
        
        // build data
        $data = array_merge([
            'NotificationURL' => $request->getNotificationUrl() ?? $this->getDefaultNotificationUrl(),
            'EndUserID' => $request->getEndUserId(),
            'MessageID' => $request->getMessageId(),
            'Attributes' => $request->getAttributes(),
        ], $extraData);
        
        // signed payload
        return $this->signPayload($method, $request->getUuid(), $data);
    }
    
    /**
     * @param string $method
     * @param string $uuid
     * @param array $payload = []
     * 
     * @return array
     */
    public function signPayload(string $method, string $uuid, array $payload = []): array
    {
        // merge username / payload with data into data
        $data = array_merge([
            'Username' => $this->username,
            'Password' => $this->password,
        ], $payload);
        
        // build payload
        return [
            'method' => $method,
            'params' => [
                'Signature' => $this->createSignature($method, $uuid, $data),
                'UUID' => $uuid,
                'Data' => $data
            ],
            'version' => $this->version
        ];
    }
    
    /**
     * @param array $responseData
     * 
     * @throws RequestException if the request response contains errors
     * 
     * @return void
     */
    private function checkErrorRepsonse(array $responseData): void
    {
        if (isset($responseData['error'])) {
            
            $message = 'response contains errors';
            
            if (isset($responseData['error']['name']) and $responseData['error']['message']) {
                
                $message = $responseData['error']['name'].': '.$responseData['error']['message'];
                
                if (isset($responseData['error']['error']['data']['details'])) {
                    $message .= ' '.$responseData['error']['error']['data']['details'];
                }
            }
            
            throw new RequestException($message);
        }
    }
    
    /**
     * @param array $data = []
     * 
     * @return array|null
     */
    public function request(array $data = []): ?array
    {
        // build options
        $options = [
            RequestOptions::JSON => $data,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json'
            ]
        ];
        
        // request
        $response = (new GuzzleCLient())->post($this->getUrl(), $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // json
        $json = json_decode($contents, true);
        
        // get response data
        $responseData = isset($json['error']) ? $json['error']['error'] :  $json['result'];
        
        // check verification param
        $this->checkVerificationParam($responseData);
        
        // assign verification param
        $this->assignVerificationParam($responseData, $method, $uuid, $signature, $data);
        
        // verify json
        $this->verify($method, $uuid, $signature, $data);
        
        // check errors
        $this->checkErrorRepsonse($json);
        
        return $json;
    }
    
    /**
     * @param callable $onSuccess = null
     * 
     * @return void
     */
    public function listen(callable $onSuccess = null): void
    {
        // create request object
        $request = HttpRequest::createFromGlobals();
        
        // get json content
        $json = json_decode($request->getContent(), true);
        
        // get params
        $method = $json['method'];
        $uuid = $json['params']['uuid'];
        $signature = $json['params']['signature'];
        $data = $json['params']['data'];
        
        // verify
        $this->verify($method, $uuid, $signature, $data);
        
        if ($onSuccess !== null) {
            ($onSuccess)($method, $uuid, $data);
        }
        
        // build response
        $responseData = [
            'status' => 'OK'
        ];
        
        // create signature
        $responseSignature = $this->createSignature($method, $uuid, $responseData);
        
        // send response
        $response = new JsonResponse([
            'result' => [
                'signature' => $responseSignature,
                'uuid' => $uuid,
                'method' => $method,
                'data' => $responseData
            ],
            'version' => $this->version
        ]);
        $response->send();
    }
}
