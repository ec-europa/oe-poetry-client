<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Source;

/**
 * Trait AssertDetailsTrait
 *
 * @method setSource(Source $detail)
 * @method getSource()
 * @method withSource()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertSourceTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Source $source1
     * @param \EC\Poetry\Messages\Components\Source $source2
     */
    function assertSource($source1, $source2)
    {
        $this->setSource($source1)->shouldReturn($this);
        $this->getSource()->shouldReturn($source1);

        $this->setSource($source2)->shouldReturn($this);
        $this->getSource()->shouldReturn($source2);

        $this->withSource()->shouldBeAnInstanceOf(Source::class);
    }
}
