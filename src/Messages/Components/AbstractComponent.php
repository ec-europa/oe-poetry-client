<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\ComponentInterface;
use EC\Poetry\Messages\Traits\ArrayAccessTrait;
use EC\Poetry\Messages\Traits\ParserAwareTrait;
use EC\Poetry\Messages\ParserAwareInterface;

/**
 * Class AbstractComponent
 *
 * @package EC\Poetry\Messages\Components
 */
abstract class AbstractComponent implements ComponentInterface, ParserAwareInterface
{
    use ArrayAccessTrait;
    use ParserAwareTrait;

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
    abstract protected function parseXml($xml);
}
