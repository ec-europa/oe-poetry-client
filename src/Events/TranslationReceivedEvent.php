<?php

namespace EC\Poetry\Events;

use Symfony\Component\EventDispatcher\Event;
use EC\Poetry\Messages\MessageAwareInterface;
use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Messages\Traits\MessageAwareTrait;

/**
 * Class TranslationReceivedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationReceivedEvent extends Event implements MessageAwareInterface
{
    use MessageAwareTrait;

    const NAME = 'poetry.translation.received';

    /**
     * TranslationReceivedEvent constructor.
     *
     * @param \EC\Poetry\Messages\MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }
}
