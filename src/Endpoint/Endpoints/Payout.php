<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Payout Endpoint.
 */
class Payout extends AbstractEndpoint
{
    /**
     * @param Request $request
     * @param string $accountId
     * @param string $amount
     * @param string $currency
     * 
     * @return array|null
     */
    public function account(
        Request $request,
        string $accountId,
        string $amount,
        string $currency
    ): ?array {
        
        $payload = $this->client->buildPayload('AccountPayout', $request, [
            'AccountID' => $accountId,
            'Amount' => $amount,
            'Currency' => $currency
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param Request $request
     * 
     * @return array|null
     */
    public function swish(Request $request): ?array
    {
        $payload = $this->client->buildPayload('SwishPayout', $request);
        
        return $this->client->request($payload);
    }
}
