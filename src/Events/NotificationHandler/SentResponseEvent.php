<?php

namespace EC\Poetry\Events\NotificationHandler;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SentResponseEvent
 *
 * @package EC\Poetry\Events\NotificationHandler
 */
class SentResponseEvent extends Event
{
    const NAME = 'poetry.notification_handler.sent_response';

    /**
     * @var string
     */
    private $message;

    /**
     * SentResponseEvent constructor.
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
