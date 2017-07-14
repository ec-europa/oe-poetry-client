<?php

namespace EC\Poetry\Services;

use EC\Poetry\Messages\AbstractMessage;
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
     * @param \EC\Poetry\Messages\AbstractMessage $message
     *
     * @return string
     */
    public function render(AbstractMessage $message)
    {
        return $this->engine->render($message->getTemplate(), [
            'identifier' => $message->getIdentifier()->getFormattedIdentifier(),
            'message' => $message,
        ]);
    }
}
