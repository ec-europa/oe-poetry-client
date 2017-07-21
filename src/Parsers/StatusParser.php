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
        $status = $this->getParser('status')->parse($xml);

        $message = new Status($identifier);
        // @todo: Consider multiple statuses.
        $message->addStatus($status);

        return $message;
    }
}
