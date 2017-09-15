<?php

namespace spec\EC\Poetry\Messages\Components;

use EC\Poetry\Messages\Components\Details;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DetailsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Details::class);
    }

    function it_should_have_setters_and_getters_working()
    {
        $this->setClientId('abc')->getClientId()->shouldReturn('abc');
        $this->setApplicationId('abc')->getApplicationId()->shouldReturn('abc');
        $this->setAuthor('abc')->getAuthor()->shouldReturn('abc');
        $this->setRequester('abc')->getRequester()->shouldReturn('abc');
        $this->setTitle('abc')->getTitle()->shouldReturn('abc');
        $this->setRemark('abc')->getRemark()->shouldReturn('abc');
        $this->setType('abc')->getType()->shouldReturn('abc');
        $this->setDestination('abc')->getDestination()->shouldReturn('abc');
        $this->setProcedure('abc')->getProcedure()->shouldReturn('abc');
        $this->setDelay('abc')->getDelay()->shouldReturn('abc');
        $this->setRequestDate('abc')->getRequestDate()->shouldReturn('abc');
        $this->setStatus('abc')->getStatus()->shouldReturn('abc');
        $this->setInterServices('abc')->getInterServices()->shouldReturn('abc');
        $this->setInterInstitution('abc')->getInterInstitution()->shouldReturn('abc');
        $this->setReferenceFilesRemark('abc')->getReferenceFilesRemark()->shouldReturn('abc');
    }
}
