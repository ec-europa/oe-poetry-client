<?php

namespace EC\Poetry\Services\Parsers\Components;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Services\Parsers\AbstractParser;

/**
 * Class IdentifierParser
 *
 * @package EC\Poetry\Services\Parsers\Components
 */
class IdentifierParser extends AbstractParser
{
    /**
     * @param string $xml
     *
     * @return \EC\Poetry\Messages\Components\Identifier|null
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = (new Identifier())
          ->setCode($crawler->getContent('POETRY/request/demandeId/codeDemandeur'))
          ->setYear($crawler->getContent('POETRY/request/demandeId/annee'))
          ->setNumber($crawler->getContent('POETRY/request/demandeId/numero'))
          ->setVersion($crawler->getContent('POETRY/request/demandeId/version'))
          ->setPart($crawler->getContent('POETRY/request/demandeId/partie'))
          ->setProduct($crawler->getContent('POETRY/request/demandeId/produit'));

        return $component;
    }
}
