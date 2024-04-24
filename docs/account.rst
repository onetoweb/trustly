.. _top:
.. title:: Account

`Back to index <index.rst>`_

=======
Account
=======

.. contents::
    :local:


Select account
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
            'Firstname' => 'Steve',
            'IP' => '83.140.44.184',
            'Lastname' => 'Smith',
            'Locale' => 'sv_SE',
            'Email' => 'test@trustly.com',
            'MobilePhone' => '+46709876543',
            'NationalIdentificationNumber' => '197901311234',
            'DateOfBirth' => '1979-01-31',
            'SuccessURL' => 'https://your_success_page.com'
        ])
    ;
    
    $result = $client->account->select($request);


Register account
````````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        ->setAttributes([
            'AddressCountry' => 'SE',
            'AddressPostalCode' => 'SE-11253',
            'AddressCity' => 'Stockholm',
            'AddressLine1' => 'Main street 1',
            'MobilePhone' => '+46709876543',
            'NationalIdentificationNumber' => '900219-1234',
            'Email' => 'test@trustly.com',
            'DateOfBirth' => '1990-02-19'
        ])
    ;
    
    // register account
    $accountNumber = '69706212';
    $bankNumber = '6112';
    $clearingHouse = 'SWEDEN';
    $firstname = 'Steve';
    $lastname = 'Smith';
    
    $result = $client->account->register($request, $accountNumber, $bankNumber, $clearingHouse, $firstname, $lastname);
