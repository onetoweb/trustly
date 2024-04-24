.. _top:
.. title:: Payment

`Back to index <index.rst>`_

=======
Payment
=======

.. contents::
    :local:


Create deposit
``````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'Country' => 'SE',
            'Locale' => 'sv_SE',
            'Currency' => 'SEK',
            'Amount' => '103.00',
            'IP' => '123.123.123.123',
            'MobilePhone' => '+46709876543',
            'Firstname' => 'John',
            'Lastname' => 'Doe',
            'Email' => 'test@trustly.com',
            'NationalIdentificationNumber' => '790131-1234',
            'SuccessURL' => 'https://yourpage.com/success',
            'FailURL' => 'https://yourpage.com/fail'
        ])
    ;
    
    // create payment deposit
    $result = $client->payment->deposit($request);
    
    // result contains url to follow and order id from trustly
    $result['result']['data']['url'];
    $result['result']['data']['orderid'];


Create iDEAL payment
````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'Country' => 'NL',
            'Locale' => 'en_NL',
            'Lastname' => 'Svensson',
            'Firstname' => 'Sven',
            'Email' => 'test@trustly.com',
            'Method' => 'deposit.bank.netherlands.ideal',
            'Amount' => '10',
            'Currency' => 'EUR',
            'FailURL' => 'https://yourpage.com/fail',
            'SuccessURL' => 'https://yourpage.com/success'
        ])
    ;
    
    // create payment deposit
    $result = $client->payment->deposit($request);


Create Swish payment
````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'MerchantSwishNumber' => '1231181189',
            'UseMobile' => '0',
            'Amount' => '25.00',
            'Currency' => 'SEK',
            'Message' => 'Pay for Merchant',
            'MobilePhone' => '46712345678',
            'NationalIdentificationNumber' => '790131-1234',
            'AgeLimit' => '18'
        ])
    ;
    
    // create payment deposit
    $result = $client->payment->swish($request);


`Back to top <#top>`_