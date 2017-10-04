<?php

namespace EC\Poetry\Messages\Components;

/**
 * Class AttributionReturnAddress
 *
 * @package EC\Poetry\Messages\Components
 */
class AttributionReturnAddress extends ReturnAddress
{

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::attribution-return-address';
    }
}
