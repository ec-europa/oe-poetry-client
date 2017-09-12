<?php

namespace EC\Poetry\Messages;

/**
 * Class ParserAwareInterface.
 *
 * @package EC\Poetry\Messages
 */
interface ParserAwareInterface
{
    /**
     * Get Parser property.
     *
     * @return \EC\Poetry\Services\Crawler
     *   Property value.
     */
    public function getParser();

    /**
     * Set Parser property.
     *
     * @param \EC\Poetry\Services\Crawler $parser
     *   Property value.
     *
     * @return $this
     */
    public function setParser($parser);

    /**
     * Create a message given its XML representation.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface
     */
    public function withXml($xml);
}
