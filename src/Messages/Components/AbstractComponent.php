<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\ComponentInterface;
use EC\Poetry\Messages\Traits\ArrayAccessTrait;
use EC\Poetry\Messages\Traits\ParserAwareTrait;

/**
 * Class AbstractComponent
 *
 * @package EC\Poetry\Messages\Components
 */
abstract class AbstractComponent implements ComponentInterface
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
     * {@inheritdoc}
     */
    public function withXml($xml)
    {
        $this->setRaw($xml);

        return $this;
    }
}
