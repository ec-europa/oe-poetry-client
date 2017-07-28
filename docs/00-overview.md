# Overview

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that users
don't have to worry about building their own request messages nor about implementing any sort of SOAP interaction.  

The library is build around the following main components:

- **The Poetry factory object**: it's responsible for initializing and orchestrating all services and dependencies. The
  factory object also allows services to be easily configured and adapted to the host application: this is the main
  entry point for a Poetry Client library user. [Read more](docs/01-poetry.md).
- **Messages**: they are responsible for building and validating request and status message objects. [Read more](docs/02-messages.md).  
- **The Client**: it's responsible for sending a request message object to the Poetry remote service and returning a valid
  status message. [Read more](docs/03-client.md).
- **The Server**: it's responsible for handling remote Poetry service callbacks and returning a valid status message.
  [Read more](docs/04-server.md).

After having properly configured the Poetry factory object the library users will be able to perform the following
operations:
 
- **Build request message object** and send it to the Poetry service via the client component.
- **Handle Poetry asynchronous requests** via the server component, requests will be modelled using message objects.

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
