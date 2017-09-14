<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;

/**
 * Send a review request to Poetry service.
 *
 * @package EC\Poetry\Messages\Requests
 */
class SendReviewRequest extends CreateRequest
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier)
    {
        parent::__construct($identifier);
        $identifier->setProduct('REV');
    }

    /**
     * {@inheritdoc}
     */
    public function getCommunication()
    {
        return self::COMMUNICATION_ASYNCHRONOUS;
    }
}
