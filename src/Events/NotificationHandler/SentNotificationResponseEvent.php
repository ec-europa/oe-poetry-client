<?php

namespace EC\Poetry\Events\NotificationHandler;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SentNotificationResponseEvent
 *
 * @package EC\Poetry\Events\NotificationHandler
 */
class SentNotificationResponseEvent extends Event
{
    const NAME = 'poetry.notification_handler.sent_notification_response';

    /**
     * @var string
     */
    private $message;

    /**
     * SentNotificationResponseEvent constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get Message property.
     *
     * @return string
     *   Property value.
     */
    public function getMessage()
    {
        return $this->message;
    }
}
