<?php

namespace spec\EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Details;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\ReferenceDocument;
use EC\Poetry\Messages\Components\ReturnAddress;
use EC\Poetry\Messages\Components\Source;
use EC\Poetry\Messages\Components\Target;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Services\Settings;
use PhpSpec\ObjectBehavior;
use spec\EC\Poetry\Messages\Traits\AssertContactsTrait;
use spec\EC\Poetry\Messages\Traits\AssertDetailsTrait;
use spec\EC\Poetry\Messages\Traits\AssertReferenceDocumentsTrait;
use spec\EC\Poetry\Messages\Traits\AssertReturnAddressTrait;
use spec\EC\Poetry\Messages\Traits\AssertSourceTrait;
use spec\EC\Poetry\Messages\Traits\AssertTargetsTrait;

class CreateTranslationRequestSpec extends ObjectBehavior
{
    use AssertDetailsTrait;
    use AssertSourceTrait;
    use AssertReturnAddressTrait;
    use AssertContactsTrait;
    use AssertReferenceDocumentsTrait;
    use AssertTargetsTrait;

    function let(Identifier $identifier, Settings $settings)
    {
        $this->beConstructedWith($identifier, $settings);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CreateTranslationRequest::class);
    }

    function it_has_details(Details $details1, Details $details2)
    {
        $this->assertDetails($details1, $details2);
    }

    function it_has_source(Source $source1, Source $source2)
    {
        $this->assertSource($source1, $source2);
    }

    function it_has_return_address(ReturnAddress $returnAddress1, ReturnAddress $returnAddress2)
    {
        $this->assertReturnAddress($returnAddress1, $returnAddress2);
    }

    function it_has_contacts(Contact $contact1, Contact $contact2, Contact $contact3, Contact $contact4)
    {
        $this->assertContacts($contact1, $contact2, $contact3, $contact4);
    }

    function it_has_reference_documents(ReferenceDocument $document1, ReferenceDocument $document2, ReferenceDocument $document3, ReferenceDocument $document4)
    {
        $this->assertReferenceDocuments($document1, $document2, $document3, $document4);
    }
    
    function it_has_targets(Target $target1, Target $target2, Target $target3, Target $target4)
    {
        $this->assertTargets($target1, $target2, $target3, $target4);
    }
}
