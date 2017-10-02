<?php

namespace EC\Poetry\Events\Notifications;

/**
 * Class TranslationReceivedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationReceivedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'poetry.notification.translation_received';
    }
}
