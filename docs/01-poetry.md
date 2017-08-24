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
| `identifier.code`         | The **code** part in an identifier string, i.e. `DGT` in `DGT/2017/0001/01/00/ABC` |
| `identifier.year`         | The **year** part in an identifier string, i.e. `2017` in `DGT/2017/0001/01/00/ABC` |
| `identifier.number`       | The **number** part in an identifier string, i.e. `0001` in `DGT/2017/0001/01/00/ABC` |
| `identifier.version`      | The **version** part in an identifier string, i.e. `01` in `DGT/2017/0001/01/00/ABC` |
| `identifier.part`         | The **part** part in an identifier string, i.e. `00` in `DGT/2017/0001/01/00/ABC` |
| `identifier.product`      | The **product** part in an identifier string, i.e. `ABC` in `DGT/2017/0001/01/00/ABC` |
| `authentication.username` | The Poetry client **username**, as provided by the Poetry service |
| `authentication.password` | The Poetry client **password**, as provided by the Poetry service |
| `client.wsdl`             | WSDL URL |
| `server.uri`              | Your application **callback URI**, the library's server should be handling its incoming requests |
| `server.callback`         | Your application **callback function**, it will be called by the Poetry service receiving an XML message |

Below an example of a fully configured `Poerty` factory, ready to be used:

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
```

The parameters above will be injected into Poetry services allowing the host application to control their behavior, namely:

- `identifier.*` will be passed to the [`Identifier` component](02-messages.md).
- `authentication.*` will be passed to the [Client](03-client.md).
- `server.*` will be passed to the [Server](04-server.md).

Once instantiated the `Poetry` factory object can be accessed anywhere by calling:

```php
$poetry = Poetry::getInstance();
```

## Services

Services can be accessed by using their machine name, for example:

```php
$renderer = $poetry->get('renderer');
$output = $renderer->render($message);
```

Client and server can be accessed using the following convenience methods:

```php
$response = $poetry->getClient()->send($message);
$response = $poetry->getServer()->handle($request);
``` 

For an overview of all available services and their machine names please refer to the service providers below:

- [`EC\Poetry\Services\Providers\ParametersProvider`](../src/Services/Providers/ParametersProvider.php): 
  Defines the list of valid configuration parameters that can be passed in the `Poetry` factory object constructor. 
- [`EC\Poetry\Services\Providers\ServicesProvider`](../src/Services/Providers/ServicesProvider.php):
  Exposes generic services such as the template system, the client, the server, etc. Services are configured by the
  parameters specified in the `ParametersProvider`.
- [`EC\Poetry\Services\Providers\MessagesProvider`](../src/Services/Providers/MessagesProvider.php): 
  Exposes message and component objects as services. Components, such as `Identifier` are configured by the parameters
  specified in the `ParametersProvider`.
- [`EC\Poetry\Services\Providers\ParsersProvider`](../src/Services/Providers/ParsersProvider.php):
  Exposes message and component parsers as services.
