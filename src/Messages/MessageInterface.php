<?php

namespace EC\Poetry\Messages;

/**
 * Interface MessageInterface
 *
 * @package EC\Poetry\Messages
 */
interface MessageInterface extends RenderableInterface, ValidatableInterface
{
    /**
     * Get Identifier property.
     *
     * @return \EC\Poetry\Messages\Components\Identifier
     *   Property value.
     */
    public function getIdentifier();
}
