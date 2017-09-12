<?php

namespace EC\Poetry\Messages\Responses;

use EC\Poetry\Messages\Components\Traits\WithStatusTrait;

/**
 * Status response, sent back to poetry server after a notification has come in.
 *
 * @package EC\Poetry\Messages\Responses
 */
class Status extends AbstractResponse
{
    use WithStatusTrait;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::status';
    }
}
