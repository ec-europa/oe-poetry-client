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
}
