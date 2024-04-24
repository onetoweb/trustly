.. title:: Index

===========
Basic Usage
===========

Setup Client

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\Trustly\Client;
    
    // param
    $privateKey = '/path/to/private.pem';
    $username = '{username}';
    $password = '{password}';
    $testModus = true;
    
    // setup client
    $client = new Client($privateKey, $username, $password, $testModus);
    
    // (optional) set default notification url
    $client->setDefaultNotificationUrl('https://example.com/listener.php');

Setup listener for notifications e.g.: https://example.com/listener.php

.. code-block:: php
    
    require 'vendor/autoload.php';
    
    use Onetoweb\Trustly\Client;
    
    // param
    $privateKey = '/path/to/private.pem';
    $username = '{username}';
    $password = '{password}';
    $testModus = true;
    
    // setup client
    $client = new Client($privateKey, $username, $password, $testModus);
    
    // listen for notifications
    $client->listen(function($method, $uuid, $data) {
        
        // callback on success after verified notification
        
    });

Building the Request object

.. code-block:: php
    
    use Onetoweb\Trustly\Request;
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build request object
    $request = (new Request($uuid))
        
        // (optional) set notification if omitted the default notification url is used
        ->setNotificationUrl('https://example.com/{unique_path}')
        
        // your unique user and message id
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
        
        // request attributes
        ->setAttributes([
            'key' => 'value'
        ])
    ;

Or use the Request::create method

.. code-block:: php
    
    use Onetoweb\Trustly\Request;
    
    $uuid = Request::generateUuid();
    $attributes = ['key' => 'value'];
    $endUserId = '{end_user_id}';
    $messageId = '{message_id}';
    $notificationUrl = 'https://example.com/{unique_path}';
    
    $request = Request::create($uuid, $attributes, $endUserId, $messageId, $notificationUrl);

========
Examples
========

* `Payment <payment.rst>`_
* `Recurring Payment <recurring_payment.rst>`_
* `Payout <payout.rst>`_
* `Refund <refund.rst>`_
* `Account <account.rst>`_
* `Report <report.rst>`_
