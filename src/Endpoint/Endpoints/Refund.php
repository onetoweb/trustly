<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Payout Endpoint.
 */
class Refund extends AbstractEndpoint
{
    /**
     * @param Request $request
     * @param string $orderId
     * @param string $amount
     * @param string $currency
     * 
     * @return array|null
     */
    public function create(
        Request $request,
        string $orderId,
        string $amount,
        string $currency
    ): ?array {
        
        $payload = $this->client->buildPayload('Refund', $request, [
            'OrderID' => $orderId,
            'Amount' => $amount,
            'Currency' => $currency
        ]);
        
        return $this->client->request($payload);
    }
}
