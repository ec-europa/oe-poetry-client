<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Events\ParseResponseEvent;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Messages\Traits\WithStatusTrait;
use EC\Poetry\Services\Parser;

/**
 * Status response, sent back to poetry server after a notification has come in.
 *
 * @package EC\Poetry\Messages\Responses
 */
class Status extends AbstractResponse
{
    use ParserAwareTrait;
    use WithStatusTrait;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::status';
    }

    /**
     * {@inheritdoc}
     */
    public function onParseResponse(ParseResponseEvent $event)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($event->getXml());
        if ($parser->getContent('POETRY/request/status') !== null) {
            $event->setMessage($this->fromXml($event->getXml()));
            $event->stopPropagation();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $xml = $parser->getOuterContent('POETRY/request/demandeId');
        $this->getIdentifier()->fromXml($xml);

        $this->setMessageId($parser->getAttribute('POETRY/request', 'id'));

        $parser->eachComponent("POETRY/request/status", function (Parser $component) {
            $this->withStatus()
                ->setParser($this->getParser())
                ->fromXml($component->outerHtml());
        }, $this);

        return $this;
    }
}
