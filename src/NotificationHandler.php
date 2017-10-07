<?php

namespace EC\Poetry;

use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Exceptions\Notifications\CannotAuthenticateException;
use EC\Poetry\Exceptions\ParsingException;
use EC\Poetry\Exceptions\ValidationException;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Services\Settings;
use EC\Poetry\Traits\DispatchExceptionEventTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
     * @var \EC\Poetry\Services\Renderer
     */
    private $renderer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * NotificationHandler constructor.
     *
     * @param \EC\Poetry\Services\Settings                              $settings
     * @param \Symfony\Component\EventDispatcher\EventDispatcher        $eventDispatcher
     * @param \EC\Poetry\Services\Renderer                              $renderer
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    public function __construct(Settings $settings, EventDispatcher $eventDispatcher, Renderer $renderer, ValidatorInterface $validator)
    {
        $this->settings = $settings;
        $this->eventDispatcher = $eventDispatcher;
        $this->renderer = $renderer;
        $this->validator = $validator;
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
            $event = $this->parse($xml);
            if (!$this->doesAuthenticate($username, $password)) {
                $this->dispatchExceptionEvent(new CannotAuthenticateException());
            }
            $violations = $this->validator->validate($event->getMessage());
            if ($violations->count() > 0) {
                $this->dispatchExceptionEvent(new ValidationException($violations));
            }
            $this->eventDispatcher->dispatch($event->getName(), $event);
        } catch (\Exception $exception) {
            return $this->getErrorStatus($exception->getMessage(), $event->getMessage());
        }

        return $this->getSuccessStatus($event->getMessage());
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
     * @param \EC\Poetry\Messages\MessageInterface $notification
     *
     * @return string
     */
    protected function getSuccessStatus($notification)
    {
        $status = new Status($notification->getIdentifier());
        $status->setMessageId($notification->getMessageId());
        $status->withStatus()
          ->setType('request')
          ->setTime(date('H:i:s'))
          ->setDate(date('d/m/Y'))
          ->setCode('0')
          ->setMessage('OK');

        return $this->renderer->render($status);
    }

    /**
     * @param string                                    $message
     * @param \EC\Poetry\Messages\MessageInterface      $notification
     *
     * @return string
     */
    protected function getErrorStatus($message, $notification)
    {
        $status = new Status($notification->getIdentifier());
        $status->setMessageId($notification->getMessageId());
        $status->withStatus()
          ->setType('request')
          ->setTime(date('H:i:s'))
          ->setDate(date('d/m/Y'))
          ->setCode('-1')
          ->setMessage($message);

        return $this->renderer->render($status);
    }
}
