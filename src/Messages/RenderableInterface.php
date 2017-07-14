<?php

namespace EC\Poetry\Messages;

/**
 * Interface RenderableInterface
 *
 * Used for messages that can be rendered.
 *
 * @package EC\Poetry
 */
interface RenderableInterface
{
    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplate();
}
