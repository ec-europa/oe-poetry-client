<?php

namespace EC\Poetry\Messages\Components;

/**
 * Class TargetReturnAddress
 *
 * @package EC\Poetry\Messages\Components
 */
class TargetReturnAddress extends ReturnAddress
{

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::target-return-address';
    }
}
