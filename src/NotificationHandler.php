<?php

namespace EC\Poetry;

use EC\Poetry\Events\TranslationReceived;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Messages\Responses\Status;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class NotificationHandler
 *
 * @package EC\Poetry
 */
class NotificationHandler
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var \EC\Poetry\Messages\Responses\Status
     */
    private $statusResponse;

    /**
     * NotificationHandler constructor.
     *
     * @param string                                             $username
     * @param string                                             $password
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     * @param \EC\Poetry\Messages\Responses\Status               $statusResponse
     */
    public function __construct($username, $password, EventDispatcher $eventDispatcher, Status $statusResponse)
    {
        $this->username = $username;
        $this->password = $password;
        $this->eventDispatcher = $eventDispatcher;
        $this->statusResponse = $statusResponse;
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
        if (!$this->doesAuthenticate($username, $password)) {
            throw new CannotAuthenticateException();
        }

        $message = $this->statusResponse->fromXml($xml);
        $event = new TranslationReceived($message);
        $this->eventDispatcher->dispatch(TranslationReceived::NAME, $event);
    }

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     */
    protected function doesAuthenticate($username, $password)
    {
        return $this->username == $username && $this->password == $password;
    }
}
