<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Messages\Components\Traits\ParserAwareTrait;
use EC\Poetry\Messages\Components\Traits\WithStatusTrait;

/**
 * Status response, sent back to poetry server after a notification has come in.
 *
 * @package EC\Poetry\Messages\Responses
 */
class Status extends AbstractResponse
{
    use ParserAwareTrait;
    use WithStatusTrait;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::status';
    }

    /**
     * {@inheritdoc}
     */
    public function fromXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        return $this;
    }
}
