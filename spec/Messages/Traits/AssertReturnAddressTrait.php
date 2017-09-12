<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\ReturnAddress;

/**
 * Trait AssertReturnAddressTrait.
 *
 * @method getReturnAddress()
 * @method setReturnAddress(ReturnAddress $returnAddress)
 * @method withReturnAddress()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertReturnAddressTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\ReturnAddress $returnAddress1
     * @param \EC\Poetry\Messages\Components\ReturnAddress $returnAddress2
     */
    function assertReturnAddress($returnAddress1, $returnAddress2)
    {
        $this->setReturnAddress($returnAddress1)->shouldReturn($this);
        $this->getReturnAddress()->shouldReturn($returnAddress1);

        $this->setReturnAddress($returnAddress2)->shouldReturn($this);
        $this->getReturnAddress()->shouldReturn($returnAddress2);

        $this->withReturnAddress()->shouldBeAnInstanceOf(ReturnAddress::class);
    }
}
