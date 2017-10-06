<?php

namespace EC\Poetry;

use EC\Poetry\Events\ExceptionEvent;
use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Exceptions\ParsingException;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Services\Settings;
use EC\Poetry\Traits\DispatchExceptionEventTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use EC\Poetry\Messages\Components\Status;

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
     * NotificationHandler constructor.
     *
     * @param \EC\Poetry\Services\Settings                       $settings
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     */
    public function __construct(Settings $settings, EventDispatcher $eventDispatcher)
    {
        $this->settings = $settings;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handle incoming Poetry notification.
     *
     * @param string $username
     * @param string $password
     * @param string $xml
     *
     * @return string
     *
     * @throws \EC\Poetry\Exceptions\Notifications\CannotAuthenticateException
     */
    public function handle($username, $password, $xml)
    {
        $event = new ReceivedNotificationEvent($username, $password, $xml);
        $this->eventDispatcher->dispatch(ReceivedNotificationEvent::NAME, $event);

        if (!$this->doesAuthenticate($username, $password)) {
            $this->dispatchExceptionEvent(new CannotAuthenticateException());
        }

        $event = $this->parse($xml);
        $message = $event->getMessage();
        $response = $message->generateResponse();
        $status = new Status();

        $status->setType('request')
          ->setTime(date('d/m/Y', time()))
          ->setDate(date('h:i:s', time()));
        if ($event->getName() == ExceptionEvent::NAME) {
            $status->setCode('-1')
              ->setMessage('NOK');
        } else {
            $status->setCode('0')
              ->setMessage('OK');
        }

        $this->eventDispatcher->dispatch($event->getName(), $event);

        $poetry = new Poetry();

        return $poetry->getRenderer()->render($response);
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
}
