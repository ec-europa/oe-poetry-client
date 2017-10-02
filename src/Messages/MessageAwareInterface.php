<?php

namespace EC\Poetry\Messages;

use EC\Poetry\Messages\MessageInterface;

/**
 * Interface MessageAwareInterface
 *
 * @package EC\Poetry\Messages
 */
interface MessageAwareInterface
{
    /**
     * @return \EC\Poetry\Messages\MessageInterface
     */
    public function getMessage();

    /**
     * @param \EC\Poetry\Messages\MessageInterface $message
     */
    public function setMessage(MessageInterface $message);

    /**
     * @return bool
     */
    public function hasMessage();
}
