<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Payment Endpoint.
 */
class Payment extends AbstractEndpoint
{
    /**
     * @param Request $request
     * 
     * @return array|null
     */
    public function deposit(Request $request): ?array
    {
        $payload = $this->client->buildPayload('Deposit', $request);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param Request $request
     * 
     * @return array|null
     */
    public function swish(Request $request): ?array
    {
        $payload = $this->client->buildPayload('Swish', $request);
        
        return $this->client->request($payload);
    }
}
