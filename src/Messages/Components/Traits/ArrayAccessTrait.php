<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Messages\ComponentInterface;

/**
 * Trait ArrayAccessTrait.
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait ArrayAccessTrait
{
    /**
     * Collect properties that do not have either a factory or a setter method.
     *
     * @var array
     */
    private $extra;

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->hasGetMethod($offset) ? $this->{$this->getGetMethod($offset)}() : '';
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        // If value is an array and we do have a with factory method then run it.
        if (is_array($value) && $this->hasWithMethod($offset)) {
            /** @var \EC\Poetry\Messages\ComponentInterface $component */
            $component = $this->{$this->getWithMethod($offset)}();
            $component->withArray($value);
        } elseif ($this->hasSetMethod($offset)) {
            $this->{$this->getSetMethod($offset)}($value);
        } else {
            $this->extra[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * Construct message or component with an array.
     *
     * @param array $properties
     * @return $this
     */
    public function withArray(array $properties)
    {
        foreach ($properties as $name => $value) {
            $this[$name] = $value;
        }

        return $this;
    }

    /**
     * Convert snake_case to CamelCase.
     *
     * @param string $string
     * @return string
     */
    protected function toCamelCase($string)
    {
        return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    /**
     * Check whereas given property has a 'with*' factory method.
     *
     * @param string $method
     * @return bool
     */
    protected function hasWithMethod($method)
    {
        return method_exists($this, 'with'.$this->toCamelCase($method));
    }

    /**
     * Check whereas given property has a 'set*' method.
     *
     * @param string $method
     * @return bool
     */
    protected function hasSetMethod($method)
    {
        return method_exists($this, 'set'.$this->toCamelCase($method));
    }

    /**
     * Check whereas given property has a 'get*' method.
     *
     * @param string $method
     * @return bool
     */
    protected function hasGetMethod($method)
    {
        return method_exists($this, 'get'.$this->toCamelCase($method));
    }

    /**
     * Get a get*' method given a camel case property.
     *
     * @param string $method
     * @return string
     */
    protected function getGetMethod($method)
    {
        return 'get'.$this->toCamelCase($method);
    }

    /**
     * Get a set*' method given a camel case property.
     *
     * @param string $method
     * @return string
     */
    protected function getSetMethod($method)
    {
        return 'set'.$this->toCamelCase($method);
    }

    /**
     * Get a with*' method given a camel case property.
     *
     * @param string $method
     * @return string
     */
    protected function getWithMethod($method)
    {
        return 'with'.$this->toCamelCase($method);
    }
}
