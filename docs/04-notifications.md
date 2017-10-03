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

use EC\Poetry\Messages\Notifications\TranslationReceived

class MyClass {
 
    public function onTranslationReceived(TranslationReceived $message)
    {
        // Do something.
    }
}
```
