<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components as Component;

/**
 * Trait AssertTargetsTrait
 *
 * @method addStatus(Component\Status $status)
 * @method setStatuses(array $statuses)
 * @method getStatuses()
 * @method withStatus()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertStatusesTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\Status $status1
     * @param \EC\Poetry\Messages\Components\Status $status2
     * @param \EC\Poetry\Messages\Components\Status $status3
     * @param \EC\Poetry\Messages\Components\Status $status4
     */
    function assertStatuses($status1, $status2,  $status3,  $status4)
    {
        $this->addStatus($status1)->shouldReturn($this);
        $this->addStatus($status2)->shouldReturn($this);
        $this->getStatuses()->shouldBeArray();
        $this->getStatuses()[0]->shouldBe($status1);
        $this->getStatuses()[1]->shouldBe($status2);

        $this->setStatuses([$status3, $status4])->shouldReturn($this);
        $this->getStatuses()[0]->shouldNotBe($status1);
        $this->getStatuses()[1]->shouldNotBe($status2);
        $this->getStatuses()[0]->shouldBe($status3);
        $this->getStatuses()[1]->shouldBe($status4);

        $this->withStatus()->shouldBeAnInstanceOf(Component\Status::class);
        $this->withStatus()->shouldBeAnInstanceOf(Component\Status::class);
        $this->getStatuses()[2]->shouldBeAnInstanceOf(Component\Status::class);
        $this->getStatuses()[3]->shouldBeAnInstanceOf(Component\Status::class);
    }
}
