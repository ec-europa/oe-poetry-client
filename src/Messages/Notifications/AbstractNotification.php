<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\ParserAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class AbstractNotification.
 *
 * @package EC\Poetry\Messages\Notifications
 */
abstract class AbstractNotification extends AbstractMessage implements ParserAwareInterface, EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
          ParseNotificationEvent::NAME => 'onParseNotification',
        ];
    }

    /**
     * @param \EC\Poetry\Events\ParseNotificationEvent $event
     *
     * @return mixed
     */
    abstract public function onParseNotification(ParseNotificationEvent $event);
}
