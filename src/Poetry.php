<?php

namespace EC\Poetry;

use EC\Poetry\Services\PoetryServiceProvider;
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
        $this->register(new PoetryServiceProvider());
        foreach ($values as $name => $value) {
            $this->extend($name, $value);
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
