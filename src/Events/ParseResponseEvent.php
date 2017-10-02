<?php

namespace EC\Poetry\Events;

use EC\Poetry\Messages\MessageAwareInterface;
use EC\Poetry\Messages\Traits\MessageAwareTrait;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ParseResponse
 *
 * @package EC\Poetry\Events
 */
class ParseResponseEvent extends Event implements MessageAwareInterface
{
    use MessageAwareTrait;

    const NAME = 'poetry.response.parse';

    /**
     * Raw message XML.
     *
     * @var
     */
    private $xml;

    /**
     * ParseResponseEvent constructor.
     *
     * @param string $xml
     */
    public function __construct($xml)
    {
        $this->xml = $xml;
    }

    /**
     * Get Xml property.
     *
     * @return mixed
     *   Property value.
     */
    public function getXml()
    {
        return $this->xml;
    }
}
