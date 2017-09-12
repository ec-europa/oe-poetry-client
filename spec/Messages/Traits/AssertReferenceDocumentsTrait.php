<?php

namespace spec\EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\ReferenceDocument;

/**
 * Trait AssertReferenceDocumentsTrait
 *
 * @method addReferenceDocument(ReferenceDocument $document)
 * @method setReferenceDocuments(array $documents)
 * @method getReferenceDocuments()
 * @method withReferenceDocument()
 *
 * @package spec\EC\Poetry\Messages\Traits
 */
trait AssertReferenceDocumentsTrait
{
    /**
     * Assert Component.
     *
     * @param \EC\Poetry\Messages\Components\ReferenceDocument $document1
     * @param \EC\Poetry\Messages\Components\ReferenceDocument $document2
     * @param \EC\Poetry\Messages\Components\ReferenceDocument $document3
     * @param \EC\Poetry\Messages\Components\ReferenceDocument $document4
     */
    function assertReferenceDocuments($document1, $document2, $document3, $document4)
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
}
