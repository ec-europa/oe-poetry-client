<?php

namespace EC\Poetry\Messages\Traits;

/**
 * Trait ArrayAccessTrait.
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait ArrayAccessTrait
{
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
        if ($this->isComponentCollection($offset, $value)) {
            $this->setComponentCollection($offset, $value);
        } elseif ($this->isComponent($offset, $value)) {
            $this->{$this->getWithMethod($offset)}()->withArray($value);
        } elseif ($this->isProperty($offset, $value)) {
            $this->{$this->getSetMethod($offset)}($value);
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

    /**
     * Check whereas given name / value pair is a simple component property.
     *
     * @param string $name
     * @param mixed  $value
     * @return bool
     */
    protected function isProperty($name, $value)
    {
        return is_scalar($value) && $this->hasSetMethod($name);
    }

    /**
     * Check whereas given name / value pair is a component.
     *
     * @param string $name
     * @param mixed  $value
     * @return bool
     */
    protected function isComponent($name, $value)
    {
        return is_array($value) && !is_int(key($value)) && $this->hasWithMethod($name);
    }

    /**
     * Check whereas given name / value pair is a collection of components.
     *
     * @param string $name
     * @param mixed  $value
     * @return bool
     */
    protected function isComponentCollection($name, $value)
    {
        return is_array($value) && is_int(key($value)) && $this->hasWithMethod($name);
    }

    /**
     * Helper method: set child components.
     *
     * @param string $parent
     * @param array $components
     */
    protected function setComponentCollection($parent, array $components)
    {
        foreach ($components as $component) {
            $this->{$this->getWithMethod($parent)}()->withArray($component);
        }
    }
}
