<?php

namespace EC\Poetry\Services;

use EC\Poetry\Messages\RenderableInterface;
use League\Plates\Engine;

/**
 * Class Renderer
 *
 * @package EC\Poetry\Services
 */
class Renderer
{
    /**
     * @var \League\Plates\Engine
     */
    private $engine;

    /**
     * Renderer constructor.
     *
     * @param \League\Plates\Engine $engine
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param \EC\Poetry\Messages\RenderableInterface $message
     *
     * @return string
     */
    public function render(RenderableInterface $message)
    {
        return $this->engine->render($message->getTemplate(), ['message' => $message]);
    }
}
