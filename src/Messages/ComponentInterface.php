<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface ComponentInterface
 *
 * @package EC\Poetry\Messages
 */
interface ComponentInterface extends \ArrayAccess
{
    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Get rendered attributes.
     *
     * @return array
     *   Array of attributes.
     */
    public function getAttributes();

    /**
     * Construct component from given array.
     *
     * @param array $properties
     * @return $this
     */
    public function withArray(array $properties);

    /**
     * @param \Symfony\Component\Validator\Mapping\ClassMetadata $metadata
     */
    public static function getConstraints(ClassMetadata $metadata);
}
