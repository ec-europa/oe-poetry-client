<?php

namespace EC\Poetry;

use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Exceptions\ParsingException;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Services\Settings;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class NotificationHandler
 *
 * @package EC\Poetry
 */
class NotificationHandler
{
    use ParserAwareTrait;

    /**
     * @var \EC\Poetry\Services\Settings
     */
    protected $settings;

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
     * @throws \EC\Poetry\Exceptions\Notifications\CannotAuthenticateException
     */
    public function handle($username, $password, $xml)
    {
        $event = new ReceivedNotificationEvent($username, $password, $xml);
        $this->eventDispatcher->dispatch(ReceivedNotificationEvent::NAME, $event);

        if (!$this->doesAuthenticate($username, $password)) {
            throw new CannotAuthenticateException();
        }

        $event = $this->parse($xml);
        $this->eventDispatcher->dispatch($event->getName(), $event);
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
            throw new ParsingException($xml);
        }

        return $event->getEvent();
    }
}
