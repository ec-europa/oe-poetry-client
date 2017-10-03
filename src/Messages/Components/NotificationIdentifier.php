<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Class NotificationIdentifier
 *
 * @package EC\Poetry\Messages\Components
 */
class NotificationIdentifier extends Identifier
{
    private $identifier;

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormattedIdentifier()
    {
        return $this->getIdentifier();
    }
}
