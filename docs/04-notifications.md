# Notifications

Notifications coming from the Poetry service will be turned into Symfony events. Host application
must register its own event listeners onto the Poetry Client library event dispatcher service:

```php
<?php
use EC\Poetry\Poetry;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;

$poetry = new Poetry(...);
$poetry->getEventDispatcher()
    ->addListener(TranslationReceivedEvent::NAME, ['MyClass', 'onTranslationReceived']);
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
```

Or having a class subscribe to multiple events:

```php
<?php

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Events\Notifications\TranslationChangedEvent;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Messages\Notifications\TranslationChanged;

class MySubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
           TranslationReceivedEvent::NAME => 'onTranslationReceivedEvent',
           TranslationChangedEvent::NAME  => 'onTranslationChangedEvent',
        ];
    }

    public function onTranslationReceivedEvent(TranslationReceived $message)
    {
        // ...
    }

    public function onTranslationChangedEvent(TranslationChanged $message)
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
```


Check Symfony's [Event Dispatcher documentation](https://symfony.com/doc/current/event_dispatcher.html) for more.
