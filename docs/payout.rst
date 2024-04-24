.. _top:
.. title:: Payout

`Back to index <index.rst>`_

======
Payout
======

.. contents::
    :local:


Create account payout
`````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'ShopperStatement' => 'Trustly.com'
        ])
    ;
    
    // create account payout
    $accountId = '1234567890';
    $amount = '800.00';
    $currency = 'EUR';
    
    $result = $client->payout->account($request, $accountId, $amount, $currency);


Create swish payout
```````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'MerchantPayoutSwishNumber' => '1231181189',
            'Amount' => '25.00',
            'Currency' => 'SEK',
            'Message' => 'Pay for Merchant',
            'NationalIdentificationNumber' => '790131-1234',
            'MobilePhone' => '46712345678'
        ])
    ;
    
    // create swish payout
    $result = $client->payout->swish($request);
