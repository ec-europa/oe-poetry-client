<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Messages\ParserAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class AbstractNotification.
 *
 * @package EC\Poetry\Messages\Notifications
 */
abstract class AbstractNotification extends AbstractMessage implements ParserAwareInterface, EventSubscriberInterface
{
    use ParserAwareTrait;

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

    /**
     * Set a message or a component internal properties given its XML representation.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    public function fromXml($xml)
    {
        $this->setRaw($xml);

        return $this->parseXml($xml);
    }

    /**
     * Parse a XML string into a set of properties.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    protected function parseXml($xml)
    {
        return $this;
    }
}
