<?php

namespace EC\Poetry\Traits;

use EC\Poetry\Events\ExceptionEvent;
use EC\Poetry\Exceptions\PoetryException;

/**
 * Trait DispatchExceptionEventTrait
 *
 * @package EC\Poetry\Traits
 */
trait DispatchExceptionEventTrait
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @param \EC\Poetry\Exceptions\PoetryException $exception
     * @param bool $silent
     */
    protected function dispatchExceptionEvent(PoetryException $exception, $silent = false)
    {
        $event = new ExceptionEvent($exception);
        $event->setSilent($silent);
        $this->getEventDispatcher()->dispatch(ExceptionEvent::NAME, $event);
    }

    /**
     * Get EventDispatcher property.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     *   Property value.
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
}
