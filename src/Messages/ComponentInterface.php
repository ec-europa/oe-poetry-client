<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface ComponentInterface
 *
 * @package EC\Poetry\Messages
 */
interface ComponentInterface
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
     * @param \Symfony\Component\Validator\Mapping\ClassMetadata $metadata
     */
    public static function getConstraints(ClassMetadata $metadata);
}
