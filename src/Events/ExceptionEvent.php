<?php

namespace EC\Poetry\Events;

use EC\Poetry\Messages\Traits\MessageAwareTrait;
use Symfony\Component\EventDispatcher\Event;
use EC\Poetry\Exceptions\PoetryException;
use EC\Poetry\Messages\MessageInterface;

/**
 * Class ExceptionEvent
 *
 * @package EC\Poetry\Events
 */
class ExceptionEvent extends Event
{
    use MessageAwareTrait;

    const NAME = 'poetry.exception';

    /**
     * @var \EC\Poetry\Exceptions\PoetryException
     */
    private $exception;

    /**
     * ExceptionEvent constructor.
     *
     * @param \EC\Poetry\Exceptions\PoetryException $exception
     * @param \EC\Poetry\Messages\MessageInterface  $message
     */
    public function __construct(PoetryException $exception, MessageInterface $message = null)
    {
        $this->exception = $exception;
        $this->message = $message;
    }

    /**
     * Get Exception property.
     *
     * @return \EC\Poetry\Exceptions\PoetryException
     *   Property value.
     */
    public function getException()
    {
        return $this->exception;
    }
}
