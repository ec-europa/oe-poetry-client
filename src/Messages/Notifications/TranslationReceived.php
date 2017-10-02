<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Messages\Traits\WithStatusTrait;
use EC\Poetry\Services\Parser;

/**
 * Class TranslationReceivedEvent
 *
 * @package EC\Poetry\Messages\Notifications
 */
class TranslationReceived extends AbstractNotification
{
    use WithStatusTrait;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function onParseNotification(ParseNotificationEvent $event)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($event->getXml());

        $parser->eachComponent('POETRY/request/status', function (Parser $component) use ($event) {
            if ('REQUEST ACCEPTED' === $component->getContent('status/statusMessage')) {
                $this->fromXml($event->getXml());
                $event->setEvent(new TranslationReceivedEvent($this));
                $event->stopPropagation();
            }
        }, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function fromXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $xml = $parser->getOuterContent('POETRY/request/demandeId');
        $this->getIdentifier()->fromXml($xml);

        $parser->eachComponent("POETRY/request/status", function (Parser $component) {
            $this->withStatus()
              ->setParser($this->getParser())
              ->fromXml($component->outerHtml());
        }, $this);

        return $this;
    }
}
