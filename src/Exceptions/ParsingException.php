<?php

namespace EC\Poetry\Exceptions;

/**
 * Class ParsingException
 *
 * @package EC\Poetry\Exceptions
 */
class ParsingException extends PoetryException
{
    protected $xml;

    /**
     * ParsingException constructor.
     *
     * @param string $xml
     */
    public function __construct($xml)
    {
        $this->xml = $xml;
        parent::__construct("XML message could not be parsed: ".$xml);
    }

    /**
     * Get Xml property.
     *
     * @return string
     *   Property value.
     */
    public function getXml()
    {
        return $this->xml;
    }
}
