<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Class StatusComponent
 *
 * @package EC\Poetry\Messages\Components
 */
class Status extends AbstractComponent implements GroupSequenceProviderInterface
{
    private $type;
    private $code;
    private $language;
    private $date;
    private $time;
    private $message;

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
        $metadata->setGroupSequenceProvider(true);
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'demande',
                'attribution',
                'request',
            ]),
        ]);
        $metadata->addPropertyConstraints('code', [
            new Assert\Choice([
                'choices' => [
                    'EXE',
                    'ONG',
                    'PRE',
                    'ENV',
                    'REF',
                    'CNL',
                    'SUS',
                ],
                'groups' => 'component',
            ]),
            new Assert\Type([
                'type' => 'scalar',
                'groups' => 'request',
            ]),
        ]);
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

        return array_filter($attributes);
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
     * Returns which validation groups should be used for a certain state
     * of the object.
     *
     * @return array An array of validation groups
     */
    public function getGroupSequence()
    {
        return [
          [
            'StatusComponent',
            $this->getType() == 'request' ? 'request' : 'component',
          ],
        ];
    }
}
