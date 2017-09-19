<?php

namespace EC\Poetry\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractEvent
 *
 * @package EC\Poetry\Events
 */
class AbstractMessageEvent extends Event
{
    /**
     * @var \EC\Poetry\Messages\MessageInterface
     */
    protected $message;

    /**
     * AbstractEvent constructor.
     *
     * @param \EC\Poetry\Messages\MessageInterface $message
     */
    public function __construct(\EC\Poetry\Messages\MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return AbstractMessageEvent
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
