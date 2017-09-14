<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Messages\Components\Traits\ParserAwareTrait;
use EC\Poetry\Messages\Components\Traits\WithStatusTrait;
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
    public function fromXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $xml = $parser->getOuterContent('POETRY/request/demandeId');
        $this->getIdentifier()->fromXml($xml);

        $parser->filterXPath("POETRY/request/status")->each(\Closure::bind(function (Parser $component) {
            $this->withStatus()
                ->setParser($this->getParser())
                ->fromXml($component->outerHtml());
        }, $this));

        return $this;
    }
}
