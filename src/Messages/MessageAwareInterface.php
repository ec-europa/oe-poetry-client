<?php

namespace EC\Poetry\Messages;

/**
 * Interface MessageAwareInterface
 *
 * @package EC\Poetry\Messages
 */
interface MessageAwareInterface
{
    /**
     * @return \EC\Poetry\Messages\AbstractMessage
     */
    public function getMessage();

    /**
     * @param \EC\Poetry\Messages\AbstractMessage $message
     */
    public function setMessage(AbstractMessage $message);

    /**
     * @return bool
     */
    public function hasMessage();
}
