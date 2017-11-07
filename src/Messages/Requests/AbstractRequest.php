<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Services\Settings;

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
     * @var \EC\Poetry\Services\Settings
     */
    protected $settings;

    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, Settings $settings)
    {
        parent::__construct($identifier);
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::request';
    }

    /**
     * Get request type.
     *
     * @return string
     */
    abstract public function getType();
}
