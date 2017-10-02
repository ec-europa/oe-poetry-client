<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\ParseNotificationEvent;

/**
 * Class TranslationReceivedEvent
 *
 * @package EC\Poetry\Messages\Notifications
 */
class TranslationReceived extends AbstractNotification
{
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        // TODO: Implement getTemplate() method.
    }

    /**
     * {@inheritdoc}
     */
    public function onParseNotification(ParseNotificationEvent $event)
    {
        // TODO: Implement onParseNotification() method.
    }

    /**
     * {@inheritdoc}
     */
    public function fromXml($xml)
    {
        // TODO: Implement fromXml() method.
    }
}
