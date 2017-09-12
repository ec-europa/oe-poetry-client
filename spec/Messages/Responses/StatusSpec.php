<?php

namespace spec\EC\Poetry\Messages\Responses;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Messages\Components as Component;
use PhpSpec\ObjectBehavior;

class StatusSpec extends ObjectBehavior
{
    function let(Identifier $identifier)
    {
        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Status::class);
    }

    function it_has_contacts(Component\Status $status1, Component\Status $status2, Component\Status $status3, Component\Status $status4)
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
