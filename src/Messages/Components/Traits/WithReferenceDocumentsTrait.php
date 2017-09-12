<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Messages\Components\ReferenceDocument;

/**
 * Contains setter, getter and factory methods for "Reference Document" component.
 *
 * @package EC\Poetry\Messages\Components\Traits
 */
trait WithReferenceDocumentsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Target[]
     */
    private $referenceDocuments;

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Target[]
     *   Property value.
     */
    public function getReferenceDocuments()
    {
        return $this->referenceDocuments;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\ReferenceDocument $referenceDocuments
     *   Property value.
     *
     * @return $this
     */
    public function setReferenceDocuments(ReferenceDocument $referenceDocuments)
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
    public function withReferenceDocuments()
    {
        static $index = 0;
        $referenceDocument = $this->referenceDocuments[$index] = new ReferenceDocument();
        $index++;

        return $referenceDocument;
    }
}
