<?php

namespace EC\Poetry\Exceptions\Notifications;

use EC\Poetry\Exceptions\NotificationException;

/**
 * Class CannotAuthenticate
 *
 * @package EC\Poetry\Exceptions\Notifications
 */
class CannotAuthenticateException extends NotificationException
{
    /**
     * CannotAuthenticate constructor.
     */
    public function __construct()
    {
        parent::__construct("Poetry service cannot authenticate on notification callback: username or password not valid.");
    }
}
