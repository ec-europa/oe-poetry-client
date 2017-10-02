<?php

namespace EC\Poetry\Events;

use Symfony\Component\EventDispatcher\Event;
use EC\Poetry\Messages\MessageAwareInterface;
use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Messages\Traits\MessageAwareTrait;

/**
 * Class TranslationChangedEvent
 *
 * @package EC\Poetry\Events
 */
class TranslationChangedEvent extends Event implements MessageAwareInterface
{
    use MessageAwareTrait;

    const NAME = 'poetry.translation.changed';

    /**
     * TranslationChangedEvent constructor.
     *
     * @param \EC\Poetry\Messages\MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }
}
