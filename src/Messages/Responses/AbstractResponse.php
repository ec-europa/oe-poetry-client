<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Events\ParseResponseEvent;
use EC\Poetry\Messages\AbstractMessage;

/**
 * Class AbstractResponse.
 *
 * @package EC\Poetry\Messages\Responses
 */
abstract class AbstractResponse extends AbstractMessage implements ResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
          ParseResponseEvent::NAME => 'onParseResponse',
        ];
    }

    /**
     * Parse response event handler.
     *
     * @param \EC\Poetry\Events\ParseResponseEvent $event
     */
    abstract public function onParseResponse(ParseResponseEvent $event);
}
