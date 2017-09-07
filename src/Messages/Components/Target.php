<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Target
 *
 * @package EC\Poetry\Messages\Components
 */
class Target extends AbstractComponent
{
    private $format;
    private $language;
    private $trackChanges;
    private $action;
    private $remark;
    private $delay;
    private $delayFormat;
    private $acceptedDelay;
    private $acceptedDelayFormat;
    private $returnAddresses;
    private $translatedFile;
    private $contacts;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::target';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('format', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'DOC',
                'DOCX',
                'HTM',
                'HTML',
                'PDF',
                'PPT',
                'RTF',
                'TIF',
                'TIFF',
                'TXT',
                'USB',
                'VSD',
                'XLS',
                'XML',
                'XMW',
                'ZIP',
            ]),
        ]);
        $metadata->addPropertyConstraints('language', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('trackChanges', new Assert\Choice(['Yes', 'No']));
        $metadata->addPropertyConstraint('action', new Assert\Choice([
            'INSERT',
            'UPDATE',
            'DELETE',
        ]));
        $metadata->addPropertyConstraint('delay', new Assert\DateTime());
        $metadata->addPropertyConstraint('acceptedDelay', new Assert\DateTime());
        $metadata->addPropertyConstraint('returnAddresses', new Assert\Valid(['traverse' => true]));
        $metadata->addPropertyConstraint('contacts', new Assert\Valid(['traverse' => true]));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
            'lgCode' => $this->getLanguage(),
            'format' => $this->getFormat(),
            'trackChanges' => $this->getTrackChanges(),
            'action' => $this->getAction(),
        ];

        return array_filter($attributes);
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {

        return $this->format;
    }

    /**
     * @param mixed $format
     * @return Target
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {

        return $this->language;
    }

    /**
     * @param mixed $language
     * @return Target
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrackChanges()
    {
        return $this->trackChanges;
    }

    /**
     * @param mixed $trackChanges
     * @return Target
     */
    public function setTrackChanges($trackChanges)
    {
        $this->trackChanges = $trackChanges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return Target
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     * @return Target
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param mixed $delay
     * @return Target
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDelayFormat()
    {
        return $this->delayFormat;
    }

    /**
     * @param mixed $delayFormat
     * @return Target
     */
    public function setDelayFormat($delayFormat)
    {
        $this->delayFormat = $delayFormat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptedDelay()
    {
        return $this->acceptedDelay;
    }

    /**
     * @param mixed $acceptedDelay
     * @return Target
     */
    public function setAcceptedDelay($acceptedDelay)
    {
        $this->acceptedDelay = $acceptedDelay;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptedDelayFormat()
    {
        return $this->acceptedDelayFormat;
    }

    /**
     * @param mixed $acceptedDelayFormat
     * @return Target
     */
    public function setAcceptedDelayFormat($acceptedDelayFormat)
    {
        $this->acceptedDelayFormat = $acceptedDelayFormat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnAddresses()
    {
        return $this->returnAddresses;
    }

    /**
     * @param mixed $returnAddresses
     * @return Target
     */
    public function setReturnAddresses($returnAddresses)
    {
        $this->returnAddresses = $returnAddresses;

        return $this;
    }

    /**
     * @param ReturnAddress $address
     * @return Target
     */
    public function addReturnAddress($address)
    {
        $this->returnAddresses[] = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranslatedFile()
    {
        return $this->translatedFile;
    }

    /**
     * @param mixed $translatedFile
     * @return Target
     */
    public function setTranslatedFile($translatedFile)
    {
        $this->translatedFile = $translatedFile;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     * @return Target
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @param Contact $contact
     * @return Target
     */
    public function addContact($contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }
}
