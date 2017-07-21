<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\StatusComponent;
use EC\Poetry\Parsers\AbstractParser;

/**
 * Class StatusComponentParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class StatusComponentParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);

        // @todo: Consider multiple statuses.
        $component = (new StatusComponent())
          ->setDate($crawler->getContent('POETRY/request/status/statusDate'))
          ->setTime($crawler->getContent('POETRY/request/status/statusTime'))
          ->setMessage($crawler->getContent('POETRY/request/status/statusMessage'))
          ->setType($crawler->getAttribute('POETRY/request/status', 'type'))
          ->setCode($crawler->getAttribute('POETRY/request/status', 'code'));

        return $component;
    }
}
