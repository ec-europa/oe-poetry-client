<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\ReferenceDocument;

/**
 * Contains setter, getter and factory methods for "Reference Document" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithReferenceDocumentsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\ReferenceDocument[]
     */
    private $referenceDocuments = [];

    /**
     * Add component.
     *
     * @param ReferenceDocument $referenceDocument
     *      Contact instance.
     *
     * @return $this
     */
    public function addReferenceDocument(ReferenceDocument $referenceDocument)
    {
        $this->referenceDocuments[] = $referenceDocument;

        return $this;
    }

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\ReferenceDocument[]
     *   Property value.
     */
    public function getReferenceDocuments()
    {
        return $this->referenceDocuments;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\ReferenceDocument[] $referenceDocuments
     *   Property value.
     *
     * @return $this
     */
    public function setReferenceDocuments(array $referenceDocuments)
    {
        $this->referenceDocuments = $referenceDocuments;

        return $this;
    }

    /**
     * Factory method: create a new ReferenceDocument and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\ReferenceDocument
     *      Target instance.
     */
    public function withReferenceDocument()
    {
        $this->referenceDocuments[] = new ReferenceDocument();

        return end($this->referenceDocuments);
    }
}
