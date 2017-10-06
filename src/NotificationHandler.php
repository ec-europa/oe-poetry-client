<?php

namespace EC\Poetry;

use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Exceptions\ParsingException;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Services\Settings;
use EC\Poetry\Traits\DispatchExceptionEventTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use EC\Poetry\Services\Renderer;

/**
 * Class NotificationHandler
 *
 * @package EC\Poetry
 */
class NotificationHandler
{
    use ParserAwareTrait;
    use DispatchExceptionEventTrait;

    /**
     * @var \EC\Poetry\Services\Settings
     */
    private $settings;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var \EC\Poetry\Services\Renderer
     */
    private $renderer;

    /**
     * @var \EC\Poetry\Messages\Responses\Status
     */
    private $status;

    /**
     * NotificationHandler constructor.
     *
     * @param \EC\Poetry\Services\Settings                       $settings
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     * @param \EC\Poetry\Services\Renderer                       $renderer
     * @param \EC\Poetry\Messages\Responses\Status               $status
     */
    public function __construct(Settings $settings, EventDispatcher $eventDispatcher, Renderer $renderer, Status $status)
    {
        $this->settings = $settings;
        $this->eventDispatcher = $eventDispatcher;
        $this->renderer = $renderer;
        $this->status = $status;
    }

    /**
     * Handle incoming Poetry notification.
     *
     * @param string $username
     * @param string $password
     * @param string $xml
     *
     * @return string
     * @throws \EC\Poetry\Exceptions\Notifications\CannotAuthenticateException
     */
    public function handle($username, $password, $xml)
    {
        $event = new ReceivedNotificationEvent($username, $password, $xml);
        $this->eventDispatcher->dispatch(ReceivedNotificationEvent::NAME, $event);

        try {
            if (!$this->doesAuthenticate($username, $password)) {
                $this->dispatchExceptionEvent(new CannotAuthenticateException());
            }

            $event = $this->parse($xml);
            $this->eventDispatcher->dispatch($event->getName(), $event);
        } catch (\Exception $exception) {
            return $this->getErrorStatus($exception->getMessage());
        }

        return $this->getSuccessStatus();
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    protected function doesAuthenticate($username, $password)
    {
        return ($this->settings->get('notification.username') == $username) && ($this->settings->get('notification.password') == $password);
    }

    /**
     * @param $xml
     *
     * @return \EC\Poetry\Events\NotificationEventInterface
     * @throws \EC\Poetry\Exceptions\ParsingException
     */
    protected function parse($xml)
    {
        $event = new ParseNotificationEvent($xml);
        $this->eventDispatcher->dispatch(ParseNotificationEvent::NAME, $event);
        if (!$event->hasEvent()) {
            $this->dispatchExceptionEvent(new ParsingException($xml));
        }

        return $event->getEvent();
    }

    /**
     * @return string
     */
    protected function getSuccessStatus()
    {
        $status = clone $this->status;
        $status->withStatus()
          ->setType('request')
          ->setTime(date('d/m/Y', time()))
          ->setDate(date('h:i:s', time()))
          ->setCode('0')
          ->setMessage('OK');

        return $this->renderer->render($status);
    }

    /**
     * @param $message
     *
     * @return string
     */
    protected function getErrorStatus($message)
    {
        $status = clone $this->status;
        $status->withStatus()
          ->setType('request')
          ->setTime(date('d/m/Y', time()))
          ->setDate(date('h:i:s', time()))
          ->setCode('-1')
          ->setMessage($message);

        return $this->renderer->render($status);
    }
}
