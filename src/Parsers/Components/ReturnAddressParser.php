<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\ReturnAddress;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;
use Pimple\Container;

/**
 * Class ReturnAddressParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class ReturnAddressParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = (new ReturnAddress())
            ->setType($crawler->getAttribute('POETRY/request/retour', 'type'))
            ->setAction($crawler->getAttribute('POETRY/request/retour', 'action'))
            ->setUser($crawler->getContent('POETRY/request/retour/retourUser'))
            ->setPassword($crawler->getContent('POETRY/request/retour/retourPassword'))
            ->setAddress($crawler->getContent('POETRY/request/retour/retourAddress'))
            ->setPath($crawler->getContent('POETRY/request/retour/retourPath'))
            ->setRemark($crawler->getContent('POETRY/request/retour/retourRemark'));

        return $component;
    }
}
