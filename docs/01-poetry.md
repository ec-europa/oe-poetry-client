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
$poetry = new Poetry();
``` 

However the code above returns a non-configured `Poetry` object.

Alternatively, you can pass the following (optional) configuration parameters to the constructor:

| Parameter                 | Description |
|---------------------------|-------------|
| `identifier.code`         | **(Required)** The **code** part in an identifier string, i.e. `DGT` in `DGT/2017/0001/01/00/ABC` |
| `identifier.year`         | **(Required)** The **year** part in an identifier string, i.e. `2017` in `DGT/2017/0001/01/00/ABC` |
| `identifier.number`       | The **number** part in an identifier string, i.e. `0001` in `DGT/2017/0001/01/00/ABC` |
| `identifier.version`      | The **version** part in an identifier string, i.e. `01` in `DGT/2017/0001/01/00/ABC` |
| `identifier.part`         | The **part** part in an identifier string, i.e. `00` in `DGT/2017/0001/01/00/ABC` |
| `authentication.username` | **(Required)** The Poetry client **username**, as provided by the Poetry service |
| `authentication.password` | **(Required)** The Poetry client **password**, as provided by the Poetry service |
| `client.wsdl`             | **(Required)** Local WSDL, contains callback information and other notification details |
| `service.wsdl`            | Poetry service WSDL URL |
| `server.uri`              | Your application **callback URI**, the library's server should be handling its incoming requests |
| `server.callback`         | Your application **callback function**, it will be called by the Poetry service receiving an XML message |

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
    'authentication.username' => 'foo',
    'authentication.password' => 'bar',
    'client.wsdl' => 'http://my-site.com/my/poetry.wsdl',
    'notification.endpoint' => 'http://my-site.com/my/poetry/notifications',
]);
```

The parameters above will be injected into Poetry services allowing the host application to control their behavior, namely:

- `identifier.*` will be passed to the [`Identifier` component](02-messages.md).
- `authentication.*` will be passed to the [Client](03-client.md).

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

- [`EC\Poetry\Services\Providers\ParametersProvider`](../src/Services/Providers/ParametersProvider.php): 
  Defines the list of valid configuration parameters that can be passed in the `Poetry` factory object constructor. 
- [`EC\Poetry\Services\Providers\ServicesProvider`](../src/Services/Providers/ServicesProvider.php):
  Exposes generic services such as the template system, the client, etc. Services are configured by parameters specified
  in the `ParametersProvider`.
- [`EC\Poetry\Services\Providers\MessagesProvider`](../src/Services/Providers/MessagesProvider.php): 
  Exposes message and component objects as services. Components, such as `Identifier` are configured by the parameters
  specified in the `ParametersProvider`.

## Use external logger

Poetry client supports any logging service implementing the [PSR3 Logger Interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

In order to add an external logger object run:

```php
// Returns a PSR3-compatible logger.
$logger = MyLoggerFactory::getInstance();

$poetry = new Poetry([
    ...
    'logger' => $logger,
]);
```

Or, for already instantiated Poetry objects, run:  

```php
// Returns a PSR3-compatible logger.
$logger = MyLoggerFactory::getInstance();

$poetry['logger'] = $logger;
```
