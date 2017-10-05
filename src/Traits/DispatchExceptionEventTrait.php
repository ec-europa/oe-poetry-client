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
     */
    protected function dispatchExceptionEvent(PoetryException $exception)
    {
        $this->eventDispatcher->dispatch(ExceptionEvent::NAME, new ExceptionEvent($exception));
    }
}
