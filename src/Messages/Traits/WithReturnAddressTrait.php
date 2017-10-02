<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\ReturnAddress;

/**
 * Contains setter, getter and factory methods for "ReturnAddress" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithReturnAddressTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\ReturnAddress
     */
    private $returnAddress;

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\ReturnAddress
     *   Property value.
     */
    public function getReturnAddress()
    {
        return $this->returnAddress;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\ReturnAddress $returnAddress
     *   Property value.
     *
     * @return $this
     */
    public function setReturnAddress($returnAddress)
    {
        $this->returnAddress = $returnAddress;

        return $this;
    }

    /**
     * Factory method: create a new return address and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\ReturnAddress
     *      Return address instance.
     */
    public function withReturnAddress()
    {
        return $this->returnAddress = new ReturnAddress();
    }
}
