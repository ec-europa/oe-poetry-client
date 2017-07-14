# Poetry Client Library

[![Build Status](https://travis-ci.org/ec-europa/oe-poetry-client.svg?branch=master)](https://travis-ci.org/ec-europa/oe-poetry-client)

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that
users don't have to worry about building their own request messages nor implementing SOAP interactions.  

## Architectural overview

### Messages

The library is built around the concept of messages, each message represents a an interaction with the Poetry server and
bundles within itself information about how to validate its data or how to get rendered into a valid SOAP request XML
document.

We have three types of messages:

- **Client messages:** represent actions the client can perform on the Poetry service, such as creating a new translation
  request, add a target language, etc. 
- **Server messages:** represent messages returned after the Poetry service performs a request on the local SOAP 
  endpoint, such as the acknowledgement of received date.
- **Error messages:** represent errors returned by the Poetry service server or by the local server. 

All the message types above share components, i.e. atomic portions of a message that are meant to be reused across
several message types, such as the request ID, details, source documents, etc.

You can build your messages as follow:

```php
use Poetry\Messages\Client as Message;
use Poetry\Messages\Components as Component;

$id = new Component\Id('DGT', '2013', '0001', '00', 'TRA');

$details = new Component\Details();
$source = new Component\SourceDocument();
$reference1 = new Component\ReferenceDocument();
$reference2 = new Component\ReferenceDocument();

$message = new Message\PublishRequest($id);
$message->setDetails($details)
  ->addContact('responsible', 'Gino Rossi')
  ->addContact('secretary', 'John Smith')
  ->setSource($source)
  ->addReference($reference1)
  ->addReference($reference2);
```


### Client

The client object is able to perform SOAP requests by receiving a fully built message object, all SOAP implementation
details are hidden from the final user.

The client will perform the following operations:

1. Validate the message and its components throwing an exception if a problem occurs
2. Render the message
3. Perform a SOAP request to the Poetry Service.  

You can send a message to the Poetry Service in the following way:

```php
$client = ClientFactory::getInstance();
$client->send($message);
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
/** @var \Poetry\Messages\Client\PublishRequest $message */
$message = $server->getResponse();
$id = $message->getId();
$detail_name = $message->getDetails()->getName();
$contacts = $message->getContacts();
```

## Dependencies

The Poetry Client Library depends on the following projects:

- [Pimple](https://pimple.symfony.com/): a simple PHP Dependency Injection Container, it is used to instantiate services
  and manage object dependency and configuration.
- [Plates](http://platesphp.com/): a lightweight, native PHP template system that is used to render messages into SOAP
  XML payload.
- [Symfony Validator Component](https://symfony.com/doc/current/components/validator.html): provides tools to validate
  message objects and their components.
