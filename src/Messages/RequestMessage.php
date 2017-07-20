<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Details;
use EC\Poetry\Messages\Components\ReturnAddress;
use EC\Poetry\Messages\Components\Source;
use EC\Poetry\Messages\Components\Target;
use EC\Poetry\Messages\Components\ReferenceDocument;

/**
 * Class RequestMessage
 *
 * @package EC\Poetry\Messages\Client
 */
class RequestMessage extends AbstractMessage implements GroupSequenceProviderInterface
{
    const REQUEST_NEW = 'new';
    const REQUEST_POST = 'post';
    const REQUEST_NEW_POST = 'newPost';
    const REQUEST_MODIFICATION = 'modification';
    const REQUEST_MODIFICATION_POST = 'modificationPost';
    const REQUEST_DELETE = 'delete';
    const REQUEST_STATUS = 'getStatus';
    const REQUEST_TRANSLATION = 'getTranslationFile';
    const REQUEST_CONTACTS = 'getContacts';

    private $type;
    private $details;
    private $contacts;
    private $returnAddress;
    private $source;
    private $targets;
    private $referenceDocuments;

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->setGroupSequenceProvider(true);
        $metadata->addPropertyConstraints('type', [
            new Assert\Choice([
                RequestMessage::REQUEST_NEW,
                RequestMessage::REQUEST_POST,
                RequestMessage::REQUEST_NEW_POST,
                RequestMessage::REQUEST_MODIFICATION,
                RequestMessage::REQUEST_MODIFICATION_POST,
                RequestMessage::REQUEST_DELETE,
                RequestMessage::REQUEST_STATUS,
                RequestMessage::REQUEST_TRANSLATION,
                RequestMessage::REQUEST_CONTACTS,
            ]),
        ]);
        $metadata->addGetterConstraints('identifier', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addGetterConstraints('details', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid(),
        ]);
        $metadata->addGetterConstraints('contacts', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid([
                'traverse' => true,
            ]),
        ]);
        $metadata->addGetterConstraints('returnAddress', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid(),
        ]);
        $metadata->addGetterConstraints('source', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid(),
        ]);
        $metadata->addGetterConstraints('targets', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid([
                'traverse' => true,
            ]),
        ]);
        $metadata->addGetterConstraints('referenceDocuments', [
            new Assert\Blank(['groups' => 'simple']),
            new Assert\Valid([
                'traverse' => true,
            ]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'client::request';
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return RequestMessage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param Details $details
     * @return RequestMessage
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return array
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param array $contacts
     * @return RequestMessage
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @param contact $contact
     * @return RequestMessage
     */
    public function addContact($contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * @return ReturnAddress
     */
    public function getReturnAddress()
    {
        return $this->returnAddress;
    }

    /**
     * @param ReturnAddress $returnAddress
     * @return RequestMessage
     */
    public function setReturnAddress($returnAddress)
    {
        $this->returnAddress = $returnAddress;

        return $this;
    }

    /**
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param Source $source
     * @return RequestMessage
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * @param array $targets
     * @return RequestMessage
     */
    public function setTargets($targets)
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * @param Target $target
     * @return RequestMessage
     */
    public function addTarget($target)
    {
        $this->targets[] = $target;

        return $this;
    }

    /**
     * @return array
     */
    public function getReferenceDocuments()
    {
        return $this->referenceDocuments;
    }

    /**
     * @param array $referenceDocuments
     * @return RequestMessage
     */
    public function setReferenceDocuments($referenceDocuments)
    {
        $this->referenceDocuments = $referenceDocuments;

        return $this;
    }

    /**
     * @param ReferenceDocument $referenceDocument
     * @return RequestMessage
     */
    public function addReferenceDocuments($referenceDocument)
    {
        $this->referenceDocuments[] = $referenceDocument;

        return $this;
    }

    /**
     * Returns which validation groups should be used for a certain state
     * of the object.
     *
     * @return array An array of validation groups
     */
    public function getGroupSequence()
    {
        $simpleRequests = [
            $this::REQUEST_POST,
            $this::REQUEST_DELETE,
            $this::REQUEST_STATUS,
            $this::REQUEST_TRANSLATION,
            $this::REQUEST_CONTACTS,
        ];
        $sequence = ['RequestMessage'];
        if (in_array($this->getType(), $simpleRequests)) {
            $sequence[] = 'simple';
        }

        return $sequence;
    }
}
