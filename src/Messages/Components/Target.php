<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\Traits\WithContactsTrait;
use EC\Poetry\Services\Parser;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use EC\Poetry\Messages\Components\Constraints as Constraint;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Target
 *
 * @package EC\Poetry\Messages\Components
 */
class Target extends AbstractComponent
{
    use WithContactsTrait;

    private $format;
    private $language;
    private $trackChanges;
    private $action;
    private $remark;
    private $delay;
    private $delayFormat;
    private $acceptedDelay;
    private $acceptedDelayFormat;
    private $translatedFile;
    private $returnAddresses;

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
            new Constraint\DocumentFormat(),
        ]);
        $metadata->addPropertyConstraints('language', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('trackChanges', new Constraint\YesNo());
        $metadata->addPropertyConstraint('action', new Assert\Choice([
            'INSERT',
            'UPDATE',
            'DELETE',
        ]));
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
     * @return \EC\Poetry\Messages\Components\TargetReturnAddress[]
     */
    public function getReturnAddresses()
    {
        return $this->returnAddresses;
    }

    /**
     * @param \EC\Poetry\Messages\Components\TargetReturnAddress[] $returnAddresses
     */
    public function setReturnAddresses($returnAddresses)
    {
        $this->returnAddresses = $returnAddresses;
    }

    /**
     * @param \EC\Poetry\Messages\Components\TargetReturnAddress $returnAddress
     */
    public function addReturnAddress($returnAddress)
    {
        $this->returnAddresses[] = $returnAddress;
    }

    /**
     * Factory method: create a new contact and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\TargetReturnAddress
     *      Contact instance.
     */
    public function withReturnAddress()
    {
        $this->returnAddresses[] = new TargetReturnAddress();

        return end($this->returnAddresses);
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);
        $this->parseAttributionContact($parser);
        $this->parseAttributionsSend($parser);
        $this->parseAttributions($parser);

        return $this;
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     */
    private function parseAttributionContact(Parser $parser)
    {
        $parser->eachComponent("attributions/attributionContact", function (Parser $component) {
            $this->withContact()
              ->setParser($this->getParser())
              ->setNickname($component->getContent('attributionContact/contactNickname'))
              ->setEmail($component->getContent('attributionContact/contactEmail'))
              ->setType($component->attr('type'))
              ->setAction($component->attr('action'));
        }, $this);
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     */
    private function parseAttributionsSend(Parser $parser)
    {
        $parser->eachComponent("attributions/attributionsSend", function (Parser $component) {
            $this->withReturnAddress()
              ->setParser($this->getParser())
              ->setType($component->attr('type'))
              ->setUser($component->getContent('attributionsSend/retourUser'))
              ->setPassword($component->getContent('attributionsSend/retourPassword'))
              ->setAddress($component->getContent('attributionsSend/retourAddress'))
              ->setPath($component->getContent('attributionsSend/retourPath'))
              ->setRemark($component->getContent('attributionsSend/retourRemark'));
        }, $this);
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     */
    private function parseAttributions(Parser $parser)
    {
        $this->setFormat($parser->getAttribute('attributions', 'format'))
          ->setLanguage($parser->getAttribute('attributions', 'lgCode'))
          ->setAction($parser->getAttribute('attributions', 'action'))
          ->setTrackChanges($parser->getAttribute('attributions', 'trackChanges'))
          ->setRemark($parser->getContent('attributions/attributionsRemark'))
          ->setDelay($parser->getContent('attributions/attributionsDelai'))
          ->setDelayFormat($parser->getAttribute('attributions/attributionsDelai', 'format'))
          ->setAcceptedDelay($parser->getContent('attributions/attributionsDelaiAccepted'))
          ->setAcceptedDelayFormat($parser->getAttribute('attributions/attributionsDelaiAccepted', 'format'))
          ->setTranslatedFile($parser->getContent('attributions/attributionsFile'));
    }
}
