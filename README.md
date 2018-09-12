# Poetry Client Library
[![Build Status](https://drone.fpfis.eu/api/badges/ec-europa/oe-poetry-client/status.svg)](https://drone.fpfis.eu/ec-europa/oe-poetry-client/)
[![Packagist](https://img.shields.io/packagist/v/ec-europa/oe-poetry-client.svg)](https://packagist.org/packages/ec-europa/oe-poetry-client)

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that
users don't have to worry about building their own request messages nor implementing SOAP interactions.  

## Installation using Docker Compose

The setup procedure can be simplified by using Docker Compose.

Requirements:

- [Docker](https://www.docker.com/get-docker)
- [Docker-compose](https://docs.docker.com/compose/)

Copy docker-compose.yml.dist into docker-compose.yml.

You can make any alterations you need for your local Docker setup. However, the defaults should be enough to set the project up.

Run:

```
$ docker-compose up -d
```

Then:

```
$ docker-compose exec web composer install
```

For more information check the documentation [here](docs/00-overview.md).
