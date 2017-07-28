# Poetry Client Library

[![Build Status](https://travis-ci.org/ec-europa/oe-poetry-client.svg?branch=master)](https://travis-ci.org/ec-europa/oe-poetry-client)

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that
users don't have to worry about building their own request messages nor implementing SOAP interactions.  

For more information check the documentation [here](docs/00-overview.md).




In this case you'll still need to set-up all required data by yourself (such as `Identifier` properties).

The Poetry object also accepts global configuration that will be passed along to the right objects and services,
for example:

```php
$poetry = new Poetry([
    'identifier.code' => 'DGT',
    'identifier.year' => '2017',
    'identifier.number' => '0001',
    'identifier.version' => '01',
    'identifier.part' => '00',
    'identifier.product' => 'ABC',
    'authentication.username' => 'foo',
    'authentication.password' => 'bar',
    'server.uri' => 'http://my-site.com/poetry-callback',
    'server.callback' => function ($user, $password, $message) {
        // Do something with message and return response.
    },    
]);

$message = $poetry->get('message.request');
$violations = $poetry->get('validator')->validate($message); // No violations.
```

The above example returns a valid message.

You can check all possible configuration parameters in `\EC\Poetry\Services\Providers\ParametersProvider::register()`.

### Client

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

### Server

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

## Dependencies

The Poetry Client Library depends on the following projects:

- [Pimple](https://pimple.symfony.com/): a simple PHP Dependency Injection Container, it is used to instantiate services
  and manage object dependency and configuration.
- [Plates](http://platesphp.com/): a lightweight, native PHP template system that is used to render messages into SOAP
  XML payload.
- [Symfony Validator Component](https://symfony.com/doc/current/components/validator.html): provides tools to validate
  message objects and their components.
- [Symfony DomCrawler Component](https://symfony.com/doc/current/components/dom_crawler.html): provides components to
  ease DOM navigation for HTML and XML documents.
