<?php

namespace EC\Poetry\Services\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class AttributesExtension
 *
 * @package EC\Poetry\Services\Plates
 */
class AttributesExtension implements ExtensionInterface
{
    /**
     * @var \League\Plates\Engine
     */
    protected $engine;

    /**
     * {@inheritdoc}
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;
        $engine->registerFunction('attributes', [$this, 'render']);
    }

    /**
     * Render given component attributes.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function render(array $attributes)
    {
        $renderedAttributes = [];
        foreach ($attributes as $key => $value) {
            $renderedAttributes[] = $key.'="'.$this->escape($value).'"';
        }

        return implode(' ', $renderedAttributes);
    }

    /**
     * @param string $string
     * @return string
     */
    public function escape($string)
    {
        return htmlspecialchars($string, ENT_XML1 | ENT_COMPAT, 'UTF-8');
    }
}
