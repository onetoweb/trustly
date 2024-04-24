<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Recurring Payment Endpoint.
 */
class RecurringPayment extends AbstractEndpoint
{
    /**
     * @param Request $request
     * 
     * @return array|null
     */
    public function createMandate(Request $request): ?array
    {
        $payload = $this->client->buildPayload('DirectDebitMandate', $request);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * @param string $orderId
     * 
     * @return array|null
     */
    public function cancelMandate(string $uuid, string $orderId): ?array
    {
        $payload = $this->client->signPayload('CancelDirectDebitMandate', $uuid, [
            'OrderID' => $orderId
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param Request $request
     * 
     * @return array|null
     */
    public function importMandate(Request $request): ?array
    {
        $payload = $this->client->buildPayload('ImportDirectDebitMandate', $request);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param Request $request
     * @param string $accountId
     * @param string $amount
     * @param string $currency
     *
     * @return array|null
     */
    public function charge(
        Request $request,
        string $accountId,
        string $amount,
        string $currency
    ): ?array {
        
        $payload = $this->client->buildPayload('Charge', $request, [
            'AccountID' => $accountId,
            'Amount' => $amount,
            'Currency' => $currency
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * @param string $orderId
     *
     * @return array|null
     */
    public function cancelCharge(string $uuid, string $orderId): ?array
    {
        $payload = $this->client->signPayload('CancelCharge', $uuid, [
            'OrderID' => $orderId
        ]);
        
        return $this->client->request($payload);
    }
}
