<?php

use EC\Poetry\Poetry;
use EC\Poetry\Events\TranslationReceived;

// @codingStandardsIgnoreStart
/**
 * Poetry callback.
 *
 * @param string $user
 * @param string $pass
 * @param string $message
 */
function OEPoetryCallback($user, $pass, $message)
{
    // @todo: Implement authentication.
    $poetry = \EC\Poetry\Poetry::getInstance();
    $message = $poetry->get('response.status')->fromXml($message);
    $event = new TranslationReceived($message);
    $poetry->getEventDispatcher()->dispatch(TranslationReceived::NAME, $event);
}
// @codingStandardsIgnoreEnd
