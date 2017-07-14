<?php

namespace EC\Poetry;

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
     * Server constructor.
     *
     * @param string $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
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
