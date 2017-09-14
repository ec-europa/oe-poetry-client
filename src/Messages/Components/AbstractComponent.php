<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\ComponentInterface;
use EC\Poetry\Messages\Components\Traits\ParserAwareTrait;
use EC\Poetry\Messages\ParserAwareInterface;

/**
 * Class AbstractComponent
 *
 * @package EC\Poetry\Messages\Components
 */
abstract class AbstractComponent implements ComponentInterface, ParserAwareInterface
{
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
}
