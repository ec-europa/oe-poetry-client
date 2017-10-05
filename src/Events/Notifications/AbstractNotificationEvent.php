<?php

namespace EC\Poetry\Events\Notifications;

use EC\Poetry\Events\NotificationEventInterface;
use Symfony\Component\EventDispatcher\Event;
use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Messages\Traits\MessageAwareTrait;

/**
 * Class AbstractNotificationEvent
 *
 * @package EC\Poetry\Events\Notifications
 */
abstract class AbstractNotificationEvent extends Event implements NotificationEventInterface
{
    use MessageAwareTrait;

    /**
     * AbstractNotificationEvent constructor.
     *
     * @param \EC\Poetry\Messages\MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }
}
