<?php

namespace EC\Poetry\Events\Notifications;

/**
 * Class TranslationChangedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationChangedEvent extends AbstractNotificationEvent
{
    const NAME = 'poetry.notification.translation_changed';
}
