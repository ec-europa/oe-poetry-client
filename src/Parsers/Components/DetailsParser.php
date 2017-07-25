<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Details;
use EC\Poetry\Parsers\AbstractParser;

/**
 * Class DetailsParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class DetailsParser extends AbstractParser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $component = (new Details())
        ->setClientId($crawler->getContent('POETRY/request/demande/userReference'))
        ->setApplicationId($crawler->getContent('POETRY/request/demande/applicationReference'))
        ->setAuthor($crawler->getContent('POETRY/request/demande/organisationAuteur'))
        ->setRequester($crawler->getContent('POETRY/request/demande/serviceDemandeur'))
        ->setTitle($crawler->getContent('POETRY/request/demande/titre'))
        ->setRemark($crawler->getContent('POETRY/request/demande/remarque'))
        ->setType($crawler->getContent('POETRY/request/demande/type'))
        ->setDestination($crawler->getContent('POETRY/request/demande/destination'))
        ->setProcedure($crawler->getContent('POETRY/request/demande/procedure'))
        ->setDelay($crawler->getContent('POETRY/request/demande/delai'))
        ->setRequestDate($crawler->getContent('POETRY/request/demande/dateDemande'))
        ->setStatus($crawler->getContent('POETRY/request/demande/statusDemande'))
        ->setInterServices($crawler->getContent('POETRY/request/demande/consultationInterServices'))
        ->setInterInstitution($crawler->getContent('POETRY/request/demande/procedureInterInstitution'))
        ->setReferenceFilesRemark($crawler->getContent('POETRY/request/demande/reference_files_note'));

        return $component;
    }
}
