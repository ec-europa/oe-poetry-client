<?php

namespace spec\EC\Poetry\Messages\Responses;

use PhpSpec\ObjectBehavior;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Messages\Components as Component;
use spec\EC\Poetry\Messages\Traits\AssertStatusesTrait;

class StatusSpec extends ObjectBehavior
{
    use AssertStatusesTrait;

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
        $this->assertStatuses($status1, $status2, $status3, $status4);
    }
}
