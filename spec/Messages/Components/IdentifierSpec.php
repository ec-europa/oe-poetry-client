<?php

namespace spec\EC\Poetry\Messages\Components;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Poetry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class IdentifierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Identifier::class);
    }

    function it_returns_formatted_identifier()
    {
        $this->setCode('1')
            ->setYear('2')
            ->setNumber('3')
            ->setVersion('4')
            ->setPart('5')
            ->setProduct('6')
            ->getFormattedIdentifier()
            ->shouldReturn('1/2/3/4/5/6');
    }

    function it_should_have_setters_and_getters_working()
    {
        $this->setCode('abc')->getCode()->shouldReturn('abc');
        $this->setVersion('abc')->getVersion()->shouldReturn('abc');
        $this->setProduct('abc')->getProduct()->shouldReturn('abc');
        $this->setPart('abc')->getPart()->shouldReturn('abc');
        $this->setNumber('abc')->getNumber()->shouldReturn('abc');
        $this->setYear('abc')->getYear()->shouldReturn('abc');
    }
}
