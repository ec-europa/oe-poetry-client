<?php

namespace EC\Poetry\Messages\Components;

/**
 * Class AbstractComponent
 *
 * @package EC\Poetry\Messages\Components
 */
abstract class AbstractComponent implements ComponentInterface
{
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
