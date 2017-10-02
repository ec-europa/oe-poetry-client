<?php

namespace EC\Poetry\Events\Notifications;

/**
 * Class TranslationChangedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationChangedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'poetry.notification.translation_changed';
    }
}
