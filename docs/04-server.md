# Server

The server object will receive an XML message from the Poetry Service and it will return a valid message object, all
SOAP implementation details are hidden from the final user.

Upon receiving a message from the Poetry Service the server will perform the following operations:

 1. Parse the XML payload
 2. Build corresponding type of message object
 3. Validate the message and its components throwing an exception if a problem occurs
 4. Return message object to the user

You can retrieve a Poetry Service response in the following way.

```php
// Call this in the application code handling the 'server.uri' parameter.
$poetry = new Poetry(...);
$poetry->getServer()->handle();

/** @var \EC\Poetry\Messages\StatusComponent $response */
$response = $poetry->getServer()->getResponse();

$id = $response->getIdentifier();
$type = $response->getStatuses()[0]->getType();
```
