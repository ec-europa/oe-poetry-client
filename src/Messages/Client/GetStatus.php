<?php

namespace EC\Poetry\Messages\Client;

/**
 * Class GetStatus
 *
 * @package EC\Poetry\Messages\Client
 */
class GetStatus extends AbstractClientMessage
{
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'client::get-status';
    }
}
