<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\AbstractMessage;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\ParserAwareInterface;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Services\Settings;

/**
 * Class AbstractRequest.
 *
 * @package EC\Poetry\Messages\Requests
 */
abstract class AbstractRequest extends AbstractMessage implements ParserAwareInterface
{
    use ParserAwareTrait;

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

    /**
     * Set a message or a component internal properties given its XML representation.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    public function fromXml($xml)
    {
        $this->setRaw($xml);

        return $this->parseXml($xml);
    }

    /**
     * Parse a XML string into a set of properties.
     *
     * @param string $xml
     *      XML string.
     *
     * @return \EC\Poetry\Messages\MessageInterface|\EC\Poetry\Messages\ComponentInterface
     */
    protected function parseXml($xml)
    {
        return $this;
    }
}
