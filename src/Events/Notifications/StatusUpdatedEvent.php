<?php

namespace EC\Poetry\Events\Notifications;

/**
 * Class StatusUpdatedEvent
 *
 * @package EC\Poetry\Events
 */
class StatusUpdatedEvent extends AbstractNotificationEvent
{
    const NAME = 'poetry.notification.status_updated';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
