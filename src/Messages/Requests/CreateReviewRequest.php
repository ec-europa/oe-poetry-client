<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Services\Settings;

/**
 * Send a review request to Poetry service.
 *
 * @package EC\Poetry\Messages\Requests
 */
class CreateReviewRequest extends CreateTranslationRequest
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, Settings $settings)
    {
        parent::__construct($identifier, $settings);
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
