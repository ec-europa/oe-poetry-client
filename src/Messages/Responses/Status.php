<?php

namespace EC\Poetry\Messages\Responses;

/**
 * Status response, sent back to poetry server after a notification has come in.
 *
 * @package EC\Poetry\Messages\Responses
 */
class Status extends AbstractResponse
{
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::request';
    }
}
