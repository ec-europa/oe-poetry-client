<?php

namespace EC\Poetry\Events;

use Symfony\Component\EventDispatcher\Event;
use EC\Poetry\Exceptions\PoetryException;

/**
 * Class ExceptionEvent
 *
 * @package EC\Poetry\Events
 */
class ExceptionEvent extends Event
{
    const NAME = 'poetry.exception';

    /**
     * @var \EC\Poetry\Exceptions\PoetryException
     */
    private $exception;

    /**
     * @var bool
     */
    private $silent = false;

    /**
     * ExceptionEvent constructor.
     *
     * @param \EC\Poetry\Exceptions\PoetryException $exception
     */
    public function __construct(PoetryException $exception)
    {
        $this->exception = $exception;
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

    /**
     * Get Silent property.
     *
     * @return bool
     *   Property value.
     */
    public function isSilent()
    {
        return $this->silent;
    }

    /**
     * Set Silent property.
     *
     * @param bool $silent
     *   Property value.
     */
    public function setSilent($silent)
    {
        $this->silent = $silent;
    }
}
