<?php

/**
 * @file
 * Contains \EC\Poetry\Messages\Requests\GetRequestStatus
 */

namespace EC\Poetry\Messages\Requests;

/**
 * Get status of a translation request.
 *
 * @package EC\Poetry\Messages\Requests
 */
class GetRequestStatus extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::REQUEST_STATUS;
    }
}
