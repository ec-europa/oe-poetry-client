<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\AbstractMessage;

/**
 * Class AbstractRequest.
 *
 * @package EC\Poetry\Messages\Requests
 */
abstract class AbstractRequest extends AbstractMessage
{
    const REQUEST_NEW = 'new';
    const REQUEST_POST = 'post';
    const REQUEST_NEW_POST = 'newPost';
    const REQUEST_MODIFICATION = 'modification';
    const REQUEST_MODIFICATION_POST = 'modificationPost';
    const REQUEST_DELETE = 'delete';
    const REQUEST_STATUS = 'getStatus';
    const REQUEST_TRANSLATION = 'getTranslationFile';
    const REQUEST_CONTACTS = 'getContacts';

    /**
     * Get request type.
     *
     * @return string
     */
    abstract public function getType();
}
