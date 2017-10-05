<?php

namespace EC\Poetry\Messages;

/**
 * Interface MessageInterface
 *
 * @package EC\Poetry\Messages
 */
interface MessageInterface extends ComponentInterface
{
    /**
     * Get Identifier property.
     *
     * @return \EC\Poetry\Messages\Components\Identifier
     *   Property value.
     */
    public function getIdentifier();

    /**
     * Get message ID.
     *
     * @return string
     */
    public function getMessageId();
}
