<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use EC\Poetry\Messages\Components\Constraints as Constraint;

/**
 * Class StatusComponent
 *
 * @package EC\Poetry\Messages\Components
 */
class Status extends AbstractComponent
{
    private $type;
    private $code;
    private $language;
    private $date;
    private $time;
    private $message;

    /**
     * Convert information in array to string.
     *
     * @return string
     */
    public function __toString()
    {
        $msg = 'Type: %s, Code: %s, Message: %s.';

        return sprintf(
            $msg,
            $this->getType(),
            $this->getCode(),
            $this->getMessage()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::status';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Constraints\StatusType(),
        ]);
        $metadata->addPropertyConstraint('code', new Constraints\StatusCode());
        $metadata->addPropertyConstraint('date', new Assert\DateTime());
        $metadata->addPropertyConstraint('time', new Assert\DateTime());
        $metadata->addPropertyConstraint('message', new Assert\Type('string'));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
          'lgCode' => $this->getLanguage(),
          'type' => $this->getType(),
          'code' => $this->getCode(),
        ];

        return array_filter($attributes, function ($value) {
            return ((string) $value) !== '';
        });
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
     *
     * @return Status
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return Status
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     *
     * @return Status
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return Status
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     *
     * @return Status
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return Status
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setDate($parser->getContent('status/statusDate'))
            ->setTime($parser->getContent('status/statusTime'))
            ->setMessage($parser->getContent('status/statusMessage'))
            ->setType($parser->attr('type'))
            ->setCode($parser->attr('code'))
            ->setLanguage($parser->attr('lgCode'));

        return $this;
    }
}
