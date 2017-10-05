<?php

namespace EC\Poetry\Events\NotificationHandler;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ReceivedNotificationEvent
 *
 * @package EC\Poetry\Events\NotificationHandler
 */
class ReceivedNotificationEvent extends Event
{
    const NAME = 'poetry.notification_handler.received_notification';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $message;

    /**
     * SendRequestEvent constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $message
     */
    public function __construct($username, $password, $message)
    {
        $this->username = $username;
        $this->password = $password;
        $this->message = $message;
    }

    /**
     * Get Username property.
     *
     * @return string
     *   Property value.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get Password property.
     *
     * @return string
     *   Property value.
     */
    public function getPassword()
    {
        return $this->password;
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
