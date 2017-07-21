<?php

namespace EC\Poetry\Parsers;

/**
 * Class ParserInterface
 *
 * @package EC\Poetry\Parsers
 */
interface ParserInterface
{
    /**
     * @param string $xml
     *
     * @return \EC\Poetry\Messages\Components\ComponentInterface|\EC\Poetry\Messages\MessageInterface
     */
    public function parse($xml);
}
