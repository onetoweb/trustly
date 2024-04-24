.. _top:
.. title:: Recurring Payment

`Back to index <index.rst>`_

=================
Recurring Payment
=================

.. contents::
    :local:


Create recurring payment mandate
````````````````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'AccountID' => '12345678',
            'MerchantReference' => '1234567890123',
            'Country' => 'GB',
            'Firstname' => 'Steve',
            'Lastname' => 'Smith',
            'Locale' => 'en_GB',
            'Email' => 'test@trustly.com',
            'MobilePhone' => '+46709876543',
            'SuccessURL' => 'https://example.com/success',
            'FailURL' => 'https://example.com/fail',
            'AddressLine1' => '74 Oxford Rd',
            'AddressCity' => 'Drighlington',
            'AddressPostalCode' => 'BD11 2YJ',
            'AddressCountry' => 'GB',
            'ReturnToAppURL' => 'yourCustomURLScheme://'
        ])
    ;
    
    // create recurring payment Mandate
    $result = $client->recurringPayment->createMandate($request);


Cancel recurring payment mandate
````````````````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    $orderId = '{order_id}';
    
    // cancel recurring payment Mandate
    $result = $client->recurringPayment->cancelMandate($uuid, $orderId);


Import recurring payment mandate
````````````````````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'AccountID' => '12345678',
            'MerchantReference' => '1234567890123',
            'ImportType' => 'CREATE',
            'Country' => 'GB',
            'Firstname' => 'Steve',
            'Lastname' => 'Smith',
            'Email' => 'test@trustly.com',
            'MobilePhone' => '+46709876543',
            'AddressLine1' => '74 Oxford Rd',
            'AddressLine2' => '',
            'AddressCity' => 'Drighlington',
            'AddressPostalCode' => 'BD11 2YJ',
            'AddressCountry' => 'GB'
        ])
    ;
    
    // import recurring payment Mandate
    $result = $client->recurringPayment->importMandate($request);


Create charge
`````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'Email' => 'test@trustly.com',
            'ShopperStatement' => 'Trustly'
        ])
    ;
    
    // create charge
    $accountId = '1234567890';
    $amount = '800.00';
    $currency = 'EUR';
    
    $result = $client->recurringPayment->charge($request, $accountId, $amount, $currency);


Cancel charge
`````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    $orderId = '{order_id}';
    
    // cancel charge
    $result = $client->recurringPayment->cancelCharge($uuid, $orderId);
