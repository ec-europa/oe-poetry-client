<?php

namespace EC\Poetry\Services\Parsers;

use EC\Poetry\Messages\Components\Identifier;

/**
 * Class IdentifierParser
 *
 * @package EC\Poetry\Services\Parsers
 */
class IdentifierParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = new Identifier();
        $component->setCode($crawler->get('POETRY/request/demandeId/codeDemandeur'))
          ->setYear($crawler->get('POETRY/request/demandeId/annee'))
          ->setNumber($crawler->get('POETRY/request/demandeId/numero'))
          ->setVersion($crawler->get('POETRY/request/demandeId/version'))
          ->setPart($crawler->get('POETRY/request/demandeId/partie'))
          ->setProduct($crawler->get('POETRY/request/demandeId/produit'));

        return $component;
    }
}
