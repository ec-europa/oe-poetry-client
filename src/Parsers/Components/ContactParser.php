<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;
use Pimple\Container;

/**
 * Class ContactParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class ContactParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $components = [];
        $crawler->filterXPath("POETRY/request/contacts")->each(function (Crawler $status) use (&$components) {
            $components[] = (new Contact())
                ->setNickname($status->getContent('contacts/contactNickname'))
                ->setEmail($status->getContent('contacts/contactEmail'))
                ->setType($status->attr('type'))
                ->setAction($status->attr('action'));
        });

        return $components;
    }
}
