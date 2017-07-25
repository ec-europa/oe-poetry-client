<?php

namespace EC\Poetry\Parsers\Components;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\ReturnAddress;
use EC\Poetry\Messages\Components\Target;
use EC\Poetry\Parsers\AbstractParser;
use EC\Poetry\Services\Crawler;

/**
 * Class TargetParser
 *
 * @package EC\Poetry\Parsers\Components
 */
class TargetParser extends AbstractParser
{
    /**
     * @param string $xml
     *
     * @return array | null
     */
    public function parse($xml)
    {
        $crawler = $this->crawler;
        $crawler->addXmlContent($xml);
        $components = [];
        $crawler->filterXPath("POETRY/request/attributions")->each(function (Crawler $target) use (&$components) {
            $contacts = [];
            $target->filterXPath("attributions/attributionContact")->each(function (Crawler $contact) use (&$contacts) {
                $contacts[] = (new Contact())
                    ->setNickname($contact->getContent('attributionContact/contactNickname'))
                    ->setEmail($contact->getContent('attributionContact/contactEmail'))
                    ->setType($contact->attr('type'))
                    ->setAction($contact->attr('action'));
            });
            $returnAddresses = [];
            $target->filterXPath("attributions/attributionsSend")->each(function (Crawler $returnAddress) use (&$returnAddresses) {
                $returnAddresses[] = (new ReturnAddress())
                    ->setType($returnAddress->attr('type'))
                    ->setAction($returnAddress->attr('action'))
                    ->setUser($returnAddress->getContent('attributionsSend/retourUser'))
                    ->setPassword($returnAddress->getContent('attributionsSend/retourPassword'))
                    ->setAddress($returnAddress->getContent('attributionsSend/retourAddress'))
                    ->setPath($returnAddress->getContent('attributionsSend/retourPath'))
                    ->setRemark($returnAddress->getContent('attributionsSend/retourRemark'));
            });

            $component = (new Target())
                ->setFormat($target->getAttribute('attributions', 'format'))
                ->setLanguage($target->getAttribute('attributions', 'lgCode'))
                ->setTrackChanges($target->getAttribute('attributions', 'trackChanges'))
                ->setRemark($target->getContent('attributions/attributionsRemark'))
                ->setDelay($target->getContent('attributions/attributionsDelai'))
                ->setDelayFormat($target->getAttribute('attributions/attributionsDelai', 'format'))
                ->setAcceptedDelay($target->getContent('attributions/attributionsDelaiAccepted'))
                ->setAcceptedDelayFormat($target->getAttribute('attributions/attributionsDelaiAccepted', 'format'))
                ->setTranslatedFile($target->getContent('attributions/attributionsFile'));
            $component->setContacts($contacts);
            $component->setReturnAddresses($returnAddresses);

            $components[] = $component;
        });

        return $components;
    }
}
