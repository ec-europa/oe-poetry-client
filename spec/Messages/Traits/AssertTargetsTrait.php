<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Target;

/**
 * Trait AssertTargetsTrait
 *
 * @method addTarget(Target $target)
 * @method setTargets(array $documents)
 * @method getTargets()
 * @method withTarget()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertTargetsTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Target $target1
     * @param \EC\Poetry\Messages\Components\Target $target2
     * @param \EC\Poetry\Messages\Components\Target $target3
     * @param \EC\Poetry\Messages\Components\Target $target4
     */
    function assertTargets($target1, $target2,  $target3,  $target4)
    {
        $this->addTarget($target1)->shouldReturn($this);
        $this->addTarget($target2)->shouldReturn($this);
        $this->getTargets()->shouldBeArray();
        $this->getTargets()[0]->shouldBe($target1);
        $this->getTargets()[1]->shouldBe($target2);

        $this->setTargets([$target3, $target4])->shouldReturn($this);
        $this->getTargets()[0]->shouldNotBe($target1);
        $this->getTargets()[1]->shouldNotBe($target2);
        $this->getTargets()[0]->shouldBe($target3);
        $this->getTargets()[1]->shouldBe($target4);

        $this->withTarget()->shouldBeAnInstanceOf(Target::class);
        $this->withTarget()->shouldBeAnInstanceOf(Target::class);
        $this->getTargets()[2]->shouldBeAnInstanceOf(Target::class);
        $this->getTargets()[3]->shouldBeAnInstanceOf(Target::class);
    }
}
