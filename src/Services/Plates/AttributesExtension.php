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
            $renderedAttributes[] = $key.'="'.htmlspecialchars($value, ENT_XML1).'"';
        }

        return implode(' ', $renderedAttributes);
    }
}
