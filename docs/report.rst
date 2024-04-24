.. _top:
.. title:: Report

`Back to index <index.rst>`_

======
Report
======

.. contents::
    :local:


Select account ledger
`````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    $fromDate = '2014-01-01';
    $toDate = '2014-01-31';
    
    // (optional)
    $currency = '';
    
    // get account ledgers
    $result = $client->report->accountLedger($uuid, $fromDate, $toDate, $currency);


Merchant settlement
```````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // create merchant settlement
    $messageId = '{message_id}';
    $amount = '800.00';
    $currency = 'EUR';
    
    $result = $client->report->merchantSettlement($uuid, $messageId, $amount, $currency);


View automatic settlement details csv
`````````````````````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // create view csv
    $currency = 'EUR';
    $settlementDate = '2018-11-17';
    
    $result = $client->report->viewAutomaticSettlementDetailsCsv($uuid, $currency, $settlementDate);


Get withdrawals
```````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // get withdrawals
    $orderId = '1436557899';
    
    $result = $client->report->withdrawals($uuid, $orderId);


Get balance
```````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // get balance
    $result = $client->report->balance($uuid);
