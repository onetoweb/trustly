<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Account Endpoint.
 */
class Account extends AbstractEndpoint
{
    /**
     * @param Request $request
     *
     * @return array|null
     */
    public function select(Request $request): ?array
    {
        $payload = $this->client->buildPayload('SelectAccount', $request);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param Request $request
     * @param string $accountNumber
     * @param string $bankNumber
     * @param string $clearingHouse
     * @param string $firstname
     * @param string $lastname
     * 
     * @return array|null
     */
    public function register(
        Request $request,
        string $accountNumber,
        string $bankNumber,
        string $clearingHouse,
        string $firstname,
        string $lastname
    ): ?array  {
        
        $payload = $this->client->buildPayload('RegisterAccount', $request, [
            'AccountNumber' => $accountNumber,
            'BankNumber' => $bankNumber,
            'ClearingHouse' => $clearingHouse,
            'Firstname' => $firstname,
            'Lastname' => $lastname
        ]);
        
        return $this->client->request($payload);
    }
}
