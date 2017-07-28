# Overview

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that users
don't have to worry about building their own request messages nor about implementing any sort of SOAP interaction.  

The library is build around the following main components:

- **The Poetry factory object**: it's responsible for initializing and orchestrating all services and dependencies. The
  factory object also allows services to be easily configured and adapted to the host application: this is the main
  entry point for a Poetry Client library user.
- **Messages**: they are responsible for building and validating request and status message objects.  
- **The Client**: it's responsible for sending a request message object to the Poetry remote service and returning a valid
  status message.
- **The Server**: it's responsible for handling remote Poetry service callbacks and returning a valid status message.

After having properly configured the Poetry factory object the library users will be able to perform the following
operations:
 
- **Build request message object** and send it to the Poetry service via the client component.
- **Handle Poetry asynchronous requests** via the server component, requests will be modelled using message objects.

