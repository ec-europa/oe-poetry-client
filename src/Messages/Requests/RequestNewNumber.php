<?php

/**
 * @file
 * Contains \EC\Poetry\Messages\Requests\RequestNewNumber
 */

namespace EC\Poetry\Messages\Requests;

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
    public function getType()
    {
        return self::REQUEST_NEW;
    }
}
