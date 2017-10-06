<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Services\Parser;

/**
 * Trait ParserAwareTrait.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait ParserAwareTrait
{
    /**
     * @var \EC\Poetry\Services\Parser
     */
    private $parser;

    /**
     * @var string
     */
    private $raw;

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param string $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * @return \EC\Poetry\Services\Parser
     */
    public function getParser()
    {
        return clone $this->parser;
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     *
     * @return $this
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }
}
