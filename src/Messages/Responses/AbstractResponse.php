<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Events\ParseResponseEvent;
use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\Traits\ParserAwareTrait;

/**
 * Class AbstractResponse.
 *
 * @package EC\Poetry\Messages\Responses
 */
abstract class AbstractResponse extends AbstractMessage implements ResponseInterface
{
    use ParserAwareTrait;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
          ParseResponseEvent::NAME => 'onParseResponse',
        ];
    }

    /**
     * Parse response event handler.
     *
     * @param \EC\Poetry\Events\ParseResponseEvent $event
     */
    abstract public function onParseResponse(ParseResponseEvent $event);

    /**
     * Set a message or a component internal properties given its XML representation.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    public function fromXml($xml)
    {
        $this->setRaw($xml);

        return $this->parseXml($xml);
    }

    /**
     * Parse a XML string into a set of properties.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    protected function parseXml($xml)
    {
        return $this;
    }
}
