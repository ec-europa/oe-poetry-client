<?php

namespace EC\Poetry\Messages;

use EC\Poetry\Services\Parser;

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
     * @return \EC\Poetry\Services\Parser
     */
    public function getParser();

    /**
     * Set Parser property.
     *
     * @param \EC\Poetry\Services\Parser $parser
     *
     * @return $this
     */
    public function setParser(Parser $parser);
}
