<?php

namespace EC\Poetry;

use EC\Poetry\Services\Parser;

/**
 * Class Server
 *
 * @package EC\Poetry
 */
class Server
{
    /**
     * Callable callback.
     *
     * @var callable
     */
    private $callback;

    /**
     * Custom XML parser.
     *
     * @var Parser
     */
    private $parser;

    /**
     * Server constructor.
     *
     * @param string $callback
     * @param Parser $parser
     */
    public function __construct($callback, $parser)
    {
        $this->callback = $callback;
        $this->parser = $parser;
    }

    /**
     * Get Callback property.
     *
     * @return mixed
     *   Property value.
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Set Callback property.
     *
     * @param mixed $callback
     *   Property value.
     *
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }
}
