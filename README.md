# Poetry Client Library

[![Build Status](https://travis-ci.org/ec-europa/oe-poetry-client.svg?branch=master)](https://travis-ci.org/ec-europa/oe-poetry-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ec-europa/oe-poetry-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ec-europa/oe-poetry-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/ec-europa/oe-poetry-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ec-europa/oe-poetry-client/?branch=master)

The Poetry Client Library aims to hide Poetry service complexity behind and easy-to-use client library so that
users don't have to worry about building their own request messages nor implementing SOAP interactions.  

For more information check the documentation [here](docs/00-overview.md).

## Tests

Run test by running:

```
$ ./vendor/bin/grumphp run 
$ ./vendor/bin/phpspec run 
$ ./vendor/bin/phpunit 
```

To produce test coverage report run:

```
$ ./vendor/bin/phpunit --coverage-html ./report
```
