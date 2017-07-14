<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface ValidatableInterface
 *
 * @package EC\Poetry\Messages
 */
interface ValidatableInterface
{
    /**
     * @param \Symfony\Component\Validator\Mapping\ClassMetadata $metadata
     */
    public static function getConstraints(ClassMetadata $metadata);
}
