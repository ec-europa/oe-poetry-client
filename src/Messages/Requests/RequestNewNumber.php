<?php

/**
 * @file
 * Contains \EC\Poetry\Messages\Requests\RequestNewNumber
 */

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;

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
    public function __construct(Identifier $identifier)
    {
        parent::__construct($identifier);
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
