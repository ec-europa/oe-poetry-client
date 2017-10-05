<?php

namespace EC\Poetry\Services;

use EC\Poetry\Events\Client\ClientResponseEvent;
use EC\Poetry\Events\Client\ClientRequestEvent;
use EC\Poetry\Events\NotificationEventInterface;
use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Events\ParseResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerSubscriber
 *
 * @package EC\Poetry\Services
 */
class LoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \EC\Poetry\Services\Renderer
     */
    protected $renderer;

    /**
     * LoggerSubscriber constructor.
     *
     * @param \Psr\Log\LoggerInterface     $logger
     * @param \EC\Poetry\Services\Renderer $renderer
     */
    public function __construct(LoggerInterface $logger, Renderer $renderer)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ParseResponseEvent::NAME        => 'onParseResponseEvent',
            ParseNotificationEvent::NAME    => 'onParseNotificationEvent',
            StatusUpdatedEvent::NAME        => 'onNotificationEvent',
            TranslationReceivedEvent::NAME  => 'onNotificationEvent',
            ClientRequestEvent::NAME        => 'onClientRequestEvent',
            ClientResponseEvent::NAME       => 'onClientResponseEvent',
            ReceivedNotificationEvent::NAME => 'onReceivedNotificationEvent',
        ];
    }

    /**
     * @param \EC\Poetry\Events\ParseResponseEvent $event
     */
    public function onParseResponseEvent(ParseResponseEvent $event)
    {
        $this->logger->info(ParseResponseEvent::NAME, ['message' => $event->getXml()]);
    }

    /**
     * @param \EC\Poetry\Events\ParseNotificationEvent $event
     */
    public function onParseNotificationEvent(ParseNotificationEvent $event)
    {
        $this->logger->info(ParseNotificationEvent::NAME, ['message' => $event->getXml()]);
    }

    /**
     * @param \EC\Poetry\Events\NotificationEventInterface $event
     */
    public function onNotificationEvent(NotificationEventInterface $event)
    {
        $message = $this->renderer->render($event->getMessage());
        $this->logger->info($event->getName(), ['message' => $message]);
    }

    /**
     * @param \EC\Poetry\Events\Client\ClientRequestEvent $event
     */
    public function onClientRequestEvent(ClientRequestEvent $event)
    {
        $this->logger->info(ClientRequestEvent::NAME, [
            'username' => $event->getUsername(),
            'password' => $this->hidePassword($event->getPassword()),
            'message' => $event->getMessage(),
        ]);
    }

    /**
     * @param \EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent $event
     */
    public function onReceivedNotificationEvent(ReceivedNotificationEvent $event)
    {
        $this->logger->info(ReceivedNotificationEvent::NAME, [
            'username' => $event->getUsername(),
            'password' => $this->hidePassword($event->getPassword()),
            'message' => $event->getMessage(),
        ]);
    }

    /**
     * @param \EC\Poetry\Events\Client\ClientResponseEvent $event
     */
    public function onClientResponseEvent(ClientResponseEvent $event)
    {
        $this->logger->info(ClientResponseEvent::NAME, ['message' => $event->getMessage()]);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function hidePassword($password)
    {
        return preg_replace("/(?!^).(?!$)/", "*", $password);
    }
}
