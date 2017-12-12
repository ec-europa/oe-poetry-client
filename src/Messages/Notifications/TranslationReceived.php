<?php

namespace EC\Poetry\Messages\Notifications;

use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Messages\Traits\WithStatusTrait;
use EC\Poetry\Messages\Traits\WithTargetsTrait;
use EC\Poetry\Services\Parser;

/**
 * Class TranslationReceived
 *
 * @package EC\Poetry\Messages\Notifications
 */
class TranslationReceived extends AbstractNotification
{
    use WithTargetsTrait;
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'notifications::translation';
    }

    /**
     * {@inheritdoc}
     */
    public function onParseNotification(ParseNotificationEvent $event)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($event->getXml());
        if ('translation' === $parser->getAttribute('POETRY/request', 'type')) {
            $this->withXml($event->getXml());
            $event->setEvent(new TranslationReceivedEvent($this));
            $event->stopPropagation();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function withXml($xml)
    {
        parent::withXml($xml);

        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $parser->eachComponent("POETRY/request/attributions", function (Parser $component) {
            $this->withTarget()
              ->setParser($this->getParser())
              ->withXml($component->outerHtml());
        }, $this);

        return $this;
    }
}
