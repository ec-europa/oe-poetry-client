<?php

namespace EC\Poetry\Events\Client;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class GetResponseEvent
 *
 * @package EC\Poetry\Events\Client
 */
class ClientResponseEvent extends Event
{
    const NAME = 'poetry.client.response';

    /**
     * @var string
     */
    private $message;

    /**
     * GetResponseEvent constructor.
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
