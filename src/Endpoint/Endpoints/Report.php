<?php

namespace Onetoweb\Trustly\Endpoint\Endpoints;

use Onetoweb\Trustly\Endpoint\AbstractEndpoint;
use Onetoweb\Trustly\Request;

/**
 * Report Endpoint.
 */
class Report extends AbstractEndpoint
{
    /**
     * @param string $uuid
     * @param string $fromDate,
     * @param string $toDate,
     * @param string $currency = null
     * 
     * @return array|null
     */
    public function accountLedger(string $uuid, string $fromDate, string $toDate, string $currency = ''): ?array
    {
        $payload = $this->client->signPayload('AccountLedger', $uuid, [
            'FromDate' => $fromDate,
            'ToDate' => $toDate,
            'Currency' => $currency
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * @param string $messageId
     * @param string $amount
     * @param string $currency
     * 
     * @return array|null
     */
    public function merchantSettlement(string $uuid, string $messageId, string $amount, string $currency): ?array
    {
        $payload = $this->client->signPayload('MerchantSettlement', $uuid, [
            'MessageID' => $messageId,
            'Amount' => $amount,
            'Currency' => $currency
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * @param string $currency
     * @param string $settlementDate
     * 
     * @return array|null
     */
    public function viewAutomaticSettlementDetailsCsv(string $uuid, string $currency, string $settlementDate): ?array
    {
        $payload = $this->client->signPayload('ViewAutomaticSettlementDetailsCSV', $uuid, [
            'Currency' => $currency,
            'SettlementDate' => $settlementDate,
            'Attributes' => [
                'APIVersion' => '1.2'
            ]
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * @param string $orderId
     * 
     * @return array|null
     */
    public function withdrawals(string $uuid, string $orderId): ?array
    {
        $payload = $this->client->signPayload('GetWithdrawals', $uuid, [
            'OrderID' => $orderId
        ]);
        
        return $this->client->request($payload);
    }
    
    /**
     * @param string $uuid
     * 
     * @return array|null
     */
    public function balance(string $uuid): ?array
    {
        $payload = $this->client->signPayload('Balance', $uuid);
        
        return $this->client->request($payload);
    }
}
