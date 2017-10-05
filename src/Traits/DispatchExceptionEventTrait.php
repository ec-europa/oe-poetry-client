<?php

namespace EC\Poetry\Traits;

use EC\Poetry\Events\ExceptionEvent;
use EC\Poetry\Exceptions\PoetryException;

/**
 * Trait DispatchExceptionEventTrait
 *
 * @property \Symfony\Component\EventDispatcher\Event $eventDispatcher
 *
 * @package EC\Poetry\Traits
 */
trait DispatchExceptionEventTrait
{
    /**
     * @param \EC\Poetry\Exceptions\PoetryException $exception
     */
    protected function dispatchExceptionEvent(PoetryException $exception)
    {
        $this->eventDispatcher->dispatch(ExceptionEvent::NAME, new ExceptionEvent($exception));
    }
}
