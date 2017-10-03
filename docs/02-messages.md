# Messages

Messages are objects that wrap a Poetry XML message, be it a request, a response or a remote server notification.

The library is built around message objects, each message represents an interaction with the remote Poetry service.
The library provides the following message types:

Message objects provide:

- **Fluent setters and getters** to access and manipulate their properties.
- **Factory methods** to easily create and re-use message components like `<demandeId/>`, `<status/>`, etc.
- **Validation rules** to make sure that their data is valid and can be safely sent to the Poetry service.
- **Renderable information** such as which template has to be used by the renderer service in order to produce an actual
  SOAP XML message.

## Usage

The following code:

```php
<?php
use EC\Poetry\Messages\Components as Component;
use EC\Poetry\Messages\Responses\Status;

$identifier = new Component\Identifier();
$identifier->setCode('DGT')
  ->setYear(2017)
  ->setNumber('00001')
  ->setVersion('01')
  ->setPart('00');

$message = new Status($identifier);
$message->withStatus()
    ->setCode(0)
    ->setDate('15/01/2017')
    ->setTime('12:30:00')
    ->setMessage('OK');
```

Will result in the following message:

```xml
    <POETRY xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="">
        <request communication="synchrone" id="DGT/2017/0001/01/00/ABC" type="status">
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

## Get messages from the service container

Alternatively Poetry can also create messages taking care of settings all necessary dependencies:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry([
    'identifier.code' => 'DGT',
    'identifier.year' => '2017',
    'identifier.number' => '0001',
    'identifier.version' => '01',
    'identifier.part' => '00',    
    'identifier.product' => 'ABC',  
]);

$message = $poetry->get('response.status');
$message->withStatus()
    ->setCode(0)
    ->setDate('15/01/2017')
    ->setTime('12:30:00')
    ->setMessage('OK');
```

In this case the `Identifier` object is created by the service container and it is used to instantiate a status 
response object.

## Validate messages

Messages can be validated by using the validator service as shown below:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry();
$violations = $poetry->getValidator()->validate($message); // No violations.
```
