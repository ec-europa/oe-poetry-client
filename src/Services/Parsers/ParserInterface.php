<?php

namespace EC\Poetry\Services\Parsers;

/**
 * Class ParserInterface
 *
 * @package EC\Poetry\Services\Parsers
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
