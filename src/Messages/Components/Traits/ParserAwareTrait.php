<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Services\Parser;

/**
 * Trait ParserAwareTrait.
 *
 * @package EC\Poetry\Messages\Components\Traits
 */
trait ParserAwareTrait
{
    /**
     * @var \EC\Poetry\Services\Parser
     */
    private $parser;

    /**
     * @return \EC\Poetry\Services\Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     *
     * @return ParserAwareTrait
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }
}
