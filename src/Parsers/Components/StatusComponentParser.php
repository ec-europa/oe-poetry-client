<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Status;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;

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
        $components = [];
        $crawler->filterXPath("POETRY/request/status")->each(function (Crawler $status) use (&$components) {
            $components[] = (new Status())
                ->setDate($status->getContent('status/statusDate'))
                ->setTime($status->getContent('status/statusTime'))
                ->setMessage($status->getContent('status/statusMessage'))
                ->setType($status->attr('type'))
                ->setCode($status->attr('code'));
        });

        return $components;
    }
}
