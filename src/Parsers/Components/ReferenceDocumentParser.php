<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\ReferenceDocument;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;

/**
 * Class ReferenceDocumentParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class ReferenceDocumentParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $components = [];
        $crawler->filterXPath("POETRY/request/documentReference")->each(function (Crawler $referenceDocument) use (&$components) {
            $components[] = (new ReferenceDocument())
                ->setLanguage($referenceDocument->attr('lgCode'))
                ->setFormat($referenceDocument->attr('format'))
                ->setType($referenceDocument->attr('type'))
                ->setAction($referenceDocument->attr('action'))
                ->setName($referenceDocument->getContent('documentReference/documentReferenceName'))
                ->setPath($referenceDocument->getContent('documentReference/documentReferencePath'))
                ->setSize($referenceDocument->getContent('documentReference/documentReferenceSize'))
                ->setRemark($referenceDocument->getContent('documentReference/documentReferenceRemark'))
                ->setFile($referenceDocument->getContent('documentReference/documentReferenceFile'));
        });

        return $components;
    }
}
