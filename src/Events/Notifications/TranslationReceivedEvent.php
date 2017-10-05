<?php

namespace EC\Poetry\Events\Notifications;

/**
 * Class TranslationReceivedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationReceivedEvent extends AbstractNotificationEvent
{
    const NAME = 'poetry.notification.translation_received';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
