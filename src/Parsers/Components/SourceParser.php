<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Source;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;

/**
 * Class SourceParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class SourceParser extends AbstractParser
{
    /**
     * @param string $xml
     *
     * @return \EC\Poetry\Messages\Components\Source|null
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = (new Source())
          ->setChannel($crawler->getAttribute('POETRY/request/documentSource', 'channel'))
          ->setDeadline($crawler->getAttribute('POETRY/request/documentSource', 'deadline'))
          ->setDeadlineStatus($crawler->getAttribute('POETRY/request/documentSource', 'statusDeadline'))
          ->setConfidential($crawler->getAttribute('POETRY/request/documentSource', 'marked'))
          ->setFormat($crawler->getAttribute('POETRY/request/documentSource', 'format'))
          ->setLegiswriteFormat($crawler->getAttribute('POETRY/request/documentSource', 'legiswrite'))
          ->setTrackChanges($crawler->getAttribute('POETRY/request/documentSource', 'trackChanges'))
          ->setName($crawler->getContent('POETRY/request/documentSource/documentSourceName'))
          ->setPath($crawler->getContent('POETRY/request/documentSource/documentSourcePath'))
          ->setSize($crawler->getContent('POETRY/request/documentSource/documentSourceSize'))
          ->setFile($crawler->getContent('POETRY/request/documentSource/documentSourceFile'));
        $languages = [];
        $crawler->filterXPath("POETRY/request/documentSource/documentSourceLang")->each(function (Crawler $language) use (&$languages) {
            $languages[$language->getAttribute('documentSourceLang', 'lgCode')] = $language->getContent('documentSourceLang/documentSourceLangPages');
        });
        $component->setLanguages($languages);

        return $component;
    }
}
