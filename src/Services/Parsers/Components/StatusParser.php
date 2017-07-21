<?php

namespace EC\Poetry\Services\Parsers\Components;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\Status;
use EC\Poetry\Services\Parsers\AbstractParser;

/**
 * Class StatusParser
 *
 * @package EC\Poetry\Services\Parsers\Components
 */
class StatusParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = (new Status())
          ->setDate($crawler->getContent('POETRY/request/status/statusDate'))
          ->setTime($crawler->getContent('POETRY/request/status/statusTime'))
          ->setMessage($crawler->getContent('POETRY/request/status/statusMessage'))
          ->setType($crawler->getAttribute('POETRY/request/status', 'type'))
          ->setCode($crawler->getAttribute('POETRY/request/status', 'code'));

        return $component;
    }
}
