<?php

namespace EC\Poetry\Events;

use EC\Poetry\Messages\MessageAwareInterface;

/**
 * Interface NotificationEventInterface
 *
 * @package EC\Poetry\Events
 */
interface NotificationEventInterface extends MessageAwareInterface
{
    /**
     * Get event name.
     *
     * @return mixed
     */
    public function getName();
}
