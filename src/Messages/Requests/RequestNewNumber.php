<?php

/**
 * @file
 * Contains \EC\Poetry\Messages\Requests\RequestNewNumber
 */

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Services\Settings;

/**
 * Get status of a translation request.
 *
 * @package EC\Poetry\Messages\Requests
 */
class RequestNewNumber extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, Settings $settings)
    {
        parent::__construct($identifier, $settings);
        $identifier->setProduct('TRA');
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::request-new-number';
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::REQUEST_NEW;
    }
}
