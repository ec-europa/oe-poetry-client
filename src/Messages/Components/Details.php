<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Details
 *
 * @package EC\Poetry\Messages\Components
 */
class Details extends AbstractComponent
{
    private $clientID;
    private $applicationID;
    private $author;
    private $requester;
    private $title;
    private $remark;
    private $type;
    private $destination;
    private $procedure;
    private $delay;
    private $requestDate;
    private $status;
    private $interServices;
    private $interInstitution;
    private $referenceFilesRemark;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::details';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('author', [
            new Assert\Type('string'),
        ]);
        $metadata->addPropertyConstraints('requester', [
            new Assert\Type('string'),
        ]);
        $metadata->addPropertyConstraints('title', [
            new Assert\Type('string'),
        ]);
        $metadata->addPropertyConstraints('remark', [
            new Assert\Type('string'),
        ]);
        $metadata->addPropertyConstraints('type', [
            new Assert\Choice(array(
                'AUTRE',
                'COMP',
                'IMG',
                'INF',
                'INTER',
                'INTRA',
                'LEGTF',
                'PUB',
            )),
        ]);
        $metadata->addPropertyConstraints('destination', [
            new Assert\Choice(array(
                'AUTRE',
                'COMMISR',
                'EM',
                'EXT',
                'IE',
                'INTERNE',
                'JO',
                'PRESSE',
                'PUBLIC',
                'RST',
            )),
        ]);
        $metadata->addPropertyConstraints('procedure', [
            new Assert\Choice(array(
                'DEGHP',
                'NEANT',
                'PROAC',
                'PROCEP',
                'PROCO',
                'REUNCS',
                'REUNAU',
                'PROCH',
                'PROCD',
            )),
        ]);
        $metadata->addPropertyConstraints('delay', [
            new Assert\DateTime(),
        ]);
        $metadata->addPropertyConstraints('requestDate', [
            new Assert\DateTime(),
        ]);
        $metadata->addPropertyConstraints('status', [
            new Assert\Type('string'),
        ]);
        $metadata->addPropertyConstraints('referenceFilesRemark', [
            new Assert\Type('string'),
        ]);
    }

    /**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param mixed $clientID
     * @return Details
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplicationID()
    {
        return $this->applicationID;
    }

    /**
     * @param mixed $applicationID
     * @return Details
     */
    public function setApplicationID($applicationID)
    {
        $this->applicationID = $applicationID;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Details
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequester()
    {
        return $this->requester;
    }

    /**
     * @param mixed $requester
     * @return Details
     */
    public function setRequester($requester)
    {
        $this->requester = $requester;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Details
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return Details
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
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
     * @return Details
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     * @return Details
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcedure()
    {
        return $this->procedure;
    }

    /**
     * @param mixed $procedure
     * @return Details
     */
    public function setProcedure($procedure)
    {
        $this->procedure = $procedure;

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
     * @return Details
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * @param mixed $requestDate
     * @return Details
     */
    public function setRequestDate($requestDate)
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Details
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterServices()
    {
        return $this->interServices;
    }

    /**
     * @param mixed $interServices
     * @return Details
     */
    public function setInterServices($interServices)
    {
        $this->interServices = $interServices;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterInstitution()
    {
        return $this->interInstitution;
    }

    /**
     * @param mixed $interInstitution
     * @return Details
     */
    public function setInterInstitution($interInstitution)
    {
        $this->interInstitution = $interInstitution;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferenceFilesRemark()
    {
        return $this->referenceFilesRemark;
    }

    /**
     * @param mixed $referenceFilesRemark
     * @return Details
     */
    public function setReferenceFilesRemark($referenceFilesRemark)
    {
        $this->referenceFilesRemark = $referenceFilesRemark;

        return $this;
    }
}
