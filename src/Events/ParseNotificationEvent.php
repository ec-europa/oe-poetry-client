<?php

namespace EC\Poetry\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ParseNotificationEvent
 *
 * @package EC\Poetry\Events
 */
class ParseNotificationEvent extends Event
{
    const NAME = 'poetry.notification.parse';

    /**
     * Raw message XML.
     *
     * @var
     */
    private $xml;

    /**
     * @var \EC\Poetry\Events\NotificationEventInterface
     */
    private $event = null;

    /**
     * ParseResponseEvent constructor.
     *
     * @param string $xml
     */
    public function __construct($xml)
    {
        $this->xml = $xml;
    }

    /**
     * Get Xml property.
     *
     * @return mixed
     *   Property value.
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * Get Event property.
     *
     * @return \EC\Poetry\Events\NotificationEventInterface
     *   Property value.
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set Event property.
     *
     * @param \EC\Poetry\Events\NotificationEventInterface $event
     *   Property value.
     */
    public function setEvent(NotificationEventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * @return bool
     */
    public function hasEvent()
    {
        return $this->event !== null;
    }
}
