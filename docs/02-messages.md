# Messages

The library is built around message objects, each message represents an interaction with the Poetry service. At the moment
the library provides the following message types:

- **Request message:** represents a request sent by the client to the Poetry service, such as creating a new translation
  request, add a target language, etc. 
- **Status message:** represents messages returned by the Poetry service and describes the status of a request, such as
  the acknowledgement of received date, an error, etc.

## Message components

Message objects are built using message components which, in turn, abstract XML details at a component level.

Both messages and message component provide:

- **Fluent setters and getters** to access and manipulate their properties.
- **Validation rules** to make sure that their data is valid and can be safely sent to the Poetry service.
- **Renderable information** such as which template has to be used by the renderer service in order to produce and actual
  SOAP XML message.

For example, let's look at the following status message:

```xml
    <POETRY xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="">
        <request communication="asynchrone" id="DGT/2017/0001/01/00/ABC" type="status">
            <demandeId>
                <codeDemandeur>DGT</codeDemandeur>
                <annee>2017</annee>
                <numero>0001</numero>
                <version>01</version>
                <partie>00</partie>
                <produit>ABC</produit>
            </demandeId>
            <status code="0" type="request">
                <statusDate format="dd/mm/yyyy">15/01/2017</statusDate>
                <statusTime format="hh:mm:ss">12:30:00</statusTime>
                <statusMessage>OK</statusMessage>
            </status>
        </request>
    </POETRY>
```

The message above contains two components:

- The message identifier: `<demandeId>...</demandeId>`
- The status information: `<status>...</status>`

## Interact with messages

The Poetry Client library models the XML message above by using the following objects:

- `EC\Poetry\Messages\Status`: The status message object itself
- `EC\Poetry\Messages\Components\Identifier`: The identifier object
- `EC\Poetry\Messages\Components\StatusComponent`: The status object

Buy using the objects above the library user can interact with the status message as follows:

```php
use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\Status;

$id = new Component\Identifier();
$id->setCode('DGT')
  ->setYear(2017)
  ->setNumber('00001')
  ->setVersion('01')
  ->setPart('00')
  ->setProduct('TRA');

$component = new Component\StatusComponent();
$component->setCode('OK');

$message = new Status($id);
$message->addStatus($component);
```

## Get messages from the service container

Alternatively Poetry can also create messages for you, taking care of settings all necessary dependencies:

```php
$component = new Component\StatusComponent();
$component->setCode('OK');

$poetry = new Poetry();
$message = $poetry->get('message.status');
$message->addStatus($component);
```
