# Poetry factory object

The `Poetry` object allows to access any component provided by the Poetry Client library, be it the client, the server
or a message object. It also provides the host application for a simple way of configuring its services.

The `Poetry` object is essentially a dependency injection container based on [Pimple](https://pimple.symfony.com/) whose only
responsibility is to build and provide ready-to-use, fully configured services.

Internally services are exposed by service providers. Each service provider class defines how services should be
constructed and which dependencies they should be injected with.

Finally, dependency injection allows the code to be fully decoupled and easily testable. 

## Configuration

To start using the Poetry Client library it's enough to create a new instance of the `Poetry` factory as follow:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry();
``` 

However the code above returns a non-configured `Poetry` object.

Alternatively, you can pass the following (optional) configuration parameters to the constructor:

| Parameter                 | Description |
|---------------------------|-------------|
| `identifier.code`         | The **code** part in an identifier string, i.e. `DGT` in `DGT/2017/0001/01/00/ABC` |
| `identifier.year`         | The **year** part in an identifier string, i.e. `2017` in `DGT/2017/0001/01/00/ABC` |
| `identifier.number`       | The **number** part in an identifier string, i.e. `0001` in `DGT/2017/0001/01/00/ABC` |
| `identifier.version`      | The **version** part in an identifier string, i.e. `01` in `DGT/2017/0001/01/00/ABC` |
| `identifier.part`         | The **part** part in an identifier string, i.e. `00` in `DGT/2017/0001/01/00/ABC` |
| `client.wsdl`             | Local WSDL, contains callback information and other notification details |
| `service.wsdl`            | Poetry service WSDL URL |
| `service.username`        | The Poetry client **username**, as provided by the Poetry service |
| `service.password`        | The Poetry client **password**, as provided by the Poetry service |
| `notification.endpoint`   | Your application's **notification callback URL**, Poetry remote service will send here its notifications |
| `notification.username`   | Your application's **notification callback username**, Poetry remote service will use it to authenticate on your `notification.endpoint` URL. |
| `notification.password`   | Your application's **notification callback password**, Poetry remote service will use it to authenticate on your `notification.endpoint` URL. |

Set the following values for `service.wsdl` according to your environment: 

- Production: `http://intragate.ec.europa.eu/DGT/poetry_services/components/poetry.cfc?wsdl`
- Testing: `http://intragate.test.ec.europa.eu/DGT/poetry_services/components/poetry.cfc?wsdl`

Below an example of a fully configured `Poerty` factory, ready to be used:

```php
$poetry = new Poetry([
    'identifier.code' => 'DGT',
    'identifier.year' => '2017',
    'identifier.number' => '0001',
    'identifier.version' => '01',
    'identifier.part' => '00',
    'service.wsdl' => 'http://intragate.test.ec.europa.eu/DGT/poetry_services/components/poetry.cfc?wsdl',
    'service.username' => 'my-remote-username',
    'service.password' => 'my-remote-password',
    'client.wsdl' => 'http://my-site.com/my/poetry.wsdl',
    'notification.endpoint' => 'http://my-site.com/my/poetry/notifications',
    'notification.username' => 'my-local-username',
    'notification.password' => 'my-local-password',
]);
```

The parameters above will be injected into Poetry services allowing the host application to control their behavior, namely:

- `identifier.*` will be used when building the [`Identifier` component](02-messages.md).
- Other settings are used in [`Client`](03-client.md) and [`NotificationHandler`](03-client.md) services.

Once instantiated the `Poetry` factory object can be accessed anywhere by calling:

```php
$poetry = Poetry::getInstance();
```

## Services

Services can be accessed by using their machine name, for example:

```php
$renderer = $poetry->get('renderer');
$output = $renderer->render($message);
$client = $poetry->get('client');
```

Some services have a convenient methods for an easier access:

```php
$response = $poetry->getClient()->send($message);
``` 

For an overview of all available services and their machine names refer to the service providers below:

- [`ServicesProvider`](../src/Services/Providers/ServicesProvider.php):
  Exposes generic services such as the template system, the client, etc. Services are configured by parameters specified
  in the [`settings`](../src/Services/Settings.php) service.
- [`MessagesProvider`](../src/Services/Providers/MessagesProvider.php): 
  Exposes message and component objects as services. Components, such as `Identifier` are configured by the parameters
  specified in the [`settings`](../src/Services/Settings.php) service.

## Use external logger

Poetry client supports any logging service implementing the [PSR3 Logger Interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

In order to add an external logger object run:

```php
<?php
use EC\Poetry\Poetry;

// Returns a PSR3-compatible logger.
$logger = MyLoggerFactory::getInstance();

$poetry = new Poetry([
    // ...
    'logger' => $logger,
]);
```

Or, for already instantiated Poetry objects, run:  

```php
<?php
// Returns a PSR3-compatible logger.
$logger = MyLoggerFactory::getInstance();

$poetry['logger'] = $logger;
```

## Set logging level

By default Poetry client will not log anything, to change that modify the `log_level` property as follow:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry([
    'log_level' => false, // Does not log anything.
]);

$poetry = new Poetry([
    'log_level' => \Psr\Log\LogLevel::INFO, // Log form "info" up, meaning all Poetry events, including exceptions.
]);


$poetry = new Poetry([
    'log_level' => \Psr\Log\LogLevel::ERROR, // Log only exceptions.
]);
```
