<?php

namespace spec\EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Details;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\ReferenceDocument;
use EC\Poetry\Messages\Components\ReturnAddress;
use EC\Poetry\Messages\Components\Source;
use EC\Poetry\Messages\Components\Target;
use EC\Poetry\Messages\Requests\CreateRequest;
use PhpSpec\ObjectBehavior;

class CreateRequestSpec extends ObjectBehavior
{
    function let(Identifier $identifier)
    {
        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateRequest::class);
    }

    function it_has_details(Details $details1, Details $details2)
    {
        $this->setDetails($details1)->shouldReturn($this);
        $this->getDetails()->shouldReturn($details1);

        $this->setDetails($details2)->shouldReturn($this);
        $this->getDetails()->shouldReturn($details2);

        $this->withDetails()->shouldBeAnInstanceOf(Details::class);
    }

    function it_has_source(Source $source1, Source $source2)
    {
        $this->setSource($source1)->shouldReturn($this);
        $this->getSource()->shouldReturn($source1);

        $this->setSource($source2)->shouldReturn($this);
        $this->getSource()->shouldReturn($source2);

        $this->withSource()->shouldBeAnInstanceOf(Source::class);
    }

    function it_has_return_address(ReturnAddress $returnAddress1, ReturnAddress $returnAddress2)
    {
        $this->setReturnAddress($returnAddress1)->shouldReturn($this);
        $this->getReturnAddress()->shouldReturn($returnAddress1);

        $this->setReturnAddress($returnAddress2)->shouldReturn($this);
        $this->getReturnAddress()->shouldReturn($returnAddress2);

        $this->withReturnAddress()->shouldBeAnInstanceOf(ReturnAddress::class);
    }

    function it_has_contacts(Contact $contact1, Contact $contact2, Contact $contact3, Contact $contact4)
    {
        $this->addContact($contact1)->shouldReturn($this);
        $this->addContact($contact2)->shouldReturn($this);
        $this->getContacts()->shouldBeArray();
        $this->getContacts()[0]->shouldBe($contact1);
        $this->getContacts()[1]->shouldBe($contact2);

        $this->setContacts([$contact3, $contact4])->shouldReturn($this);
        $this->getContacts()[0]->shouldNotBe($contact1);
        $this->getContacts()[1]->shouldNotBe($contact2);
        $this->getContacts()[0]->shouldBe($contact3);
        $this->getContacts()[1]->shouldBe($contact4);

        $this->withContact()->shouldBeAnInstanceOf(Contact::class);
        $this->withContact()->shouldBeAnInstanceOf(Contact::class);
        $this->getContacts()[2]->shouldBeAnInstanceOf(Contact::class);
        $this->getContacts()[3]->shouldBeAnInstanceOf(Contact::class);
    }

    function it_has_reference_documents(ReferenceDocument $document1, ReferenceDocument $document2, ReferenceDocument $document3, ReferenceDocument $document4)
    {
        $this->addReferenceDocument($document1)->shouldReturn($this);
        $this->addReferenceDocument($document2)->shouldReturn($this);
        $this->getReferenceDocuments()->shouldBeArray();
        $this->getReferenceDocuments()[0]->shouldBe($document1);
        $this->getReferenceDocuments()[1]->shouldBe($document2);

        $this->setReferenceDocuments([$document3, $document4])->shouldReturn($this);
        $this->getReferenceDocuments()[0]->shouldNotBe($document1);
        $this->getReferenceDocuments()[1]->shouldNotBe($document2);
        $this->getReferenceDocuments()[0]->shouldBe($document3);
        $this->getReferenceDocuments()[1]->shouldBe($document4);

        $this->withReferenceDocument()->shouldBeAnInstanceOf(ReferenceDocument::class);
        $this->withReferenceDocument()->shouldBeAnInstanceOf(ReferenceDocument::class);
        $this->getReferenceDocuments()[2]->shouldBeAnInstanceOf(ReferenceDocument::class);
        $this->getReferenceDocuments()[3]->shouldBeAnInstanceOf(ReferenceDocument::class);
    }
    
    function it_has_targets(Target $target1, Target $target2, Target $target3, Target $target4)
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
