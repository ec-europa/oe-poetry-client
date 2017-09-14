# Overview

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that users
don't have to worry about building their own request messages nor about implementing any sort of SOAP interaction.  

The library is build around the following main components:

- **Poetry factory object**: it's responsible for initializing and orchestrating all services and dependencies. The
  factory object also allows services to be easily configured by the host application. This is the main
  entry point library users. [Read more](01-poetry.md).
- **Messages**: they are responsible for building and validating request and status messages. [Read more](02-messages.md).  
- **Client**: it's responsible for sending a request message to the Poetry service. [Read more](03-client.md).
- **Server notifications**: notifications coming from the Poetry Server will be turned into events that library users
  will be able to subscribe to.

After having properly configured the Poetry factory object library users will be able to perform the following
operations:
 
- Build and send message objects.
- Subscribe and handle Poetry service notifications.

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
