<?php

namespace EC\Poetry;

use EC\Poetry\Services\PoetryServiceProvider;
use EC\Poetry\Services\Providers\MessagesProvider;
use EC\Poetry\Services\Providers\ServicesProvider;
use Pimple\Container;

/**
 * Class Poetry
 *
 * @package Poetry
 */
class Poetry extends Container
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        // Register services.
        $this->register(new ServicesProvider());
        $this->register(new MessagesProvider());

        // Allow for container parameters and services to be overridden.
        foreach ($values as $name => $value) {
            $this->offsetSet($name, $value);
        }
    }

    /**
     * Return service object or parameter value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this[$name];
    }
}
