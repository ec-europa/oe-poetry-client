<?php

namespace EC\Poetry\Parsers;

use EC\Poetry\Messages\Status;

/**
 * Class StatusComponentParser
 *
 * @package EC\Poetry\Parsers
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

        /** @var \EC\Poetry\Messages\Components\Identifier $identifier */
        $identifier = $this->getParser('identifier')->parse($xml);
        $statuses = $this->getParser('status')->parse($xml);

        $message = new Status($identifier);
        $message->setStatuses($statuses);

        return $message;
    }
}
