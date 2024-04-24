.. _top:
.. title:: Refund

`Back to index <index.rst>`_

======
Refund
======

.. contents::
    :local:


Create refund
`````````````

.. code-block:: php
    
    // generate your own uuid4 id
    $uuid = Request::generateUuid();
    
    // build Request object
    $request = (new Request($uuid))
        ->setNotificationUrl('https://example.com/{unique_path}')
        ->setEndUserId('{end_user_id}')
        ->setMessageId('{message_id}')
    ;
    
    // create refund
    $orderId = '1187741486';
    $amount = '30.00';
    $currency = 'EUR';
    
    $result = $client->refund->create($request, $orderId, $amount, $currency);
