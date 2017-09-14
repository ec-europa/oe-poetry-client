<?php

namespace EC\Poetry\Messages;

use EC\Poetry\Messages\Components\Identifier;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractMessage
 *
 * @package EC\Poetry\Messages
 */
abstract class AbstractMessage implements MessageInterface
{
    const COMMUNICATION_SYNCHRONOUS = 'synchrone';
    const COMMUNICATION_ASYNCHRONOUS = 'asynchrone';

    /**
     * @var \EC\Poetry\Messages\Components\Identifier
     */
    private $identifier;

    /**
     * AbstractMessage constructor.
     *
     * @param \EC\Poetry\Messages\Components\Identifier $identifier
     */
    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('identifier', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
    }

    /**
     * Get rendered attributes.
     *
     * @return array
     *   Array of attributes.
     */
    public function getAttributes()
    {
        return [];
    }

    /**
     * Get communication type for current message object.
     *
     * @return string
     */
    public function getCommunication()
    {
        return self::COMMUNICATION_SYNCHRONOUS;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set Identifier property.
     *
     * @param \EC\Poetry\Messages\Components\Identifier $identifier
     *   Property value.
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
}
