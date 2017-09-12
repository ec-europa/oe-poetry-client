<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Details;

/**
 * Trait AssertDetailsTrait
 *
 * @method getDetails()
 * @method setDetails(Details $detail)
 * @method withDetails()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertDetailsTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Details $details1
     * @param \EC\Poetry\Messages\Components\Details $details2
     */
    function assertDetails($details1, $details2)
    {
        $this->setDetails($details1)->shouldReturn($this);
        $this->getDetails()->shouldReturn($details1);

        $this->setDetails($details2)->shouldReturn($this);
        $this->getDetails()->shouldReturn($details2);

        $this->withDetails()->shouldBeAnInstanceOf(Details::class);
    }
}
