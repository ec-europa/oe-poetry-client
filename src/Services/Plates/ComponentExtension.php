<?php

namespace EC\Poetry\Services\Plates;

use EC\Poetry\Messages\ComponentInterface;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

/**
 * Class ComponentExtension
 *
 * @package EC\Poetry\Services\Plates
 */
class ComponentExtension implements ExtensionInterface
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
        $engine->registerFunction('component', [$this, 'render']);
    }

    /**
     * Render given component.
     *
     * @param \EC\Poetry\Messages\ComponentInterface $component
     *
     * @return string
     */
    public function render(ComponentInterface $component)
    {
        return $this->engine->render($component->getTemplate(), ['component' => $component]);
    }
}
