<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Attribution;

/**
 * Trait AssertAttributionsTrait
 *
 * @method addAttribution(Attribution $attribution)
 * @method setAttribution(array $documents)
 * @method getAttributions()
 * @method withAttribution()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertAttributionsTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Attribution $attribution1
     * @param \EC\Poetry\Messages\Components\Attribution $attribution2
     * @param \EC\Poetry\Messages\Components\Attribution $attribution3
     * @param \EC\Poetry\Messages\Components\Attribution $attribution4
     */
    function assertAttributions($attribution1, $attribution2, $attribution3, $attribution4)
    {
        $this->addAttribution($attribution1)->shouldReturn($this);
        $this->addAttribution($attribution2)->shouldReturn($this);
        $this->getAttributions()->shouldBeArray();
        $this->getAttributions()[0]->shouldBe($attribution1);
        $this->getAttributions()[1]->shouldBe($attribution2);

        $this->setAttribution([$attribution3, $attribution4])->shouldReturn($this);
        $this->getAttributions()[0]->shouldNotBe($attribution1);
        $this->getAttributions()[1]->shouldNotBe($attribution2);
        $this->getAttributions()[0]->shouldBe($attribution3);
        $this->getAttributions()[1]->shouldBe($attribution4);

        $this->withAttribution()->shouldBeAnInstanceOf(Attribution::class);
        $this->withAttribution()->shouldBeAnInstanceOf(Attribution::class);
        $this->getAttributions()[2]->shouldBeAnInstanceOf(Attribution::class);
        $this->getAttributions()[3]->shouldBeAnInstanceOf(Attribution::class);
    }
}
