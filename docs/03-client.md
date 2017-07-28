# Client

The client object is able to perform SOAP requests by receiving a fully built message object, all SOAP implementation
details are hidden from the final user.

The client will perform the following operations:

1. Validate the message and its components throwing an exception if a problem occurs
2. Render the message
3. Perform a SOAP request to the Poetry Service.  

You can send a message to the Poetry Service in the following way:

```php
$poetry = new Poetry(...);
$response = $poetry->getClient()->send($message);
```
