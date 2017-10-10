# Notifications

Notifications coming from the Poetry service will be turned into Symfony events.
 
## Expose a notification endpoint

Host application must expose a notification endpoint and handle incoming requests to such endpoint using the Poetry
Client server.

Say that you wish to use the following URL in order to receive Poetry notifications:

```
http://my-site.europa.eu/poetry
``` 

Make sure that the following code is executed when a request hits the URL above:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry(...);
$poetry->getServer()->handle();
exit;
```

## Register notification listeners

In order to handle incoming notifications you need to register your event listeners onto the Poetry Client library event
dispatcher service.

The core above might then become:

```php
<?php
use EC\Poetry\Poetry;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;

$poetry = new Poetry(...);
$poetry->getEventDispatcher()
    ->addListener(TranslationReceivedEvent::NAME, ['MyClass', 'onTranslationReceived']);
$poetry->getServer()->handle();
``` 

Event listeners will receive the incoming notification as an actual notification message object:

```php
<?php

use EC\Poetry\Messages\Notifications\TranslationReceived;

class MyClass {
 
    public function onTranslationReceived(TranslationReceived $message)
    {
        // ...
    }
}
```

Alternatively you can also pass a closure as event handler:

```php
<?php
use EC\Poetry\Poetry;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Messages\Notifications\TranslationReceived;

$poetry = new Poetry(...);
$poetry->getEventDispatcher()
    ->addListener(TranslationReceivedEvent::NAME, function (TranslationReceived $message) {
        // ...
    });
$poetry->getServer()->handle();
```

Or having a class subscribe to multiple events:

```php
<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Messages\Notifications\StatusUpdated;

class MySubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
           TranslationReceivedEvent::NAME => 'onTranslationReceivedEvent',
           StatusUpdatedEvent::NAME  => 'onStatusUpdatedEvent',
        ];
    }

    public function onTranslationReceivedEvent(TranslationReceived $message)
    {
        // ...
    }

    public function onStatusUpdatedEvent(StatusUpdated $message)
    {
        // ...
    }
}
```

Subscriber class will need to be added to the event dispatcher as follow:

```php
<?php
use EC\Poetry\Poetry;

$poetry = new Poetry(...);
$poetry->getEventDispatcher()
    ->addSubscriber(new MySubscriber());
$poetry->getServer()->handle();
```


Check Symfony's [Event Dispatcher documentation](https://symfony.com/doc/current/event_dispatcher.html) for more.
