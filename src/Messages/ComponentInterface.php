<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface ComponentInterface
 *
 * @package EC\Poetry\Messages
 */
interface ComponentInterface extends ParserAwareInterface, \ArrayAccess
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
     *
     * @return $this
     */
    public function withArray(array $properties);

    /**
     * Set message or component internal properties given its XML representation.
     *
     * @param string $xml
     *
     * @return $this
     */
    public function withXml($xml);

    /**
     * Get raw XML.
     *
     * @return string
     */
    public function getRaw();

    /**
     * Set raw XML.
     *
     * @param string $raw
     *
     * @return $this
     */
    public function setRaw($raw);

    /**
     * @param \Symfony\Component\Validator\Mapping\ClassMetadata $metadata
     */
    public static function getConstraints(ClassMetadata $metadata);
}
