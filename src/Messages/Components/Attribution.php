<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Attribution.
 *
 * @package EC\Poetry\Messages\Components
 */
class Attribution extends AbstractComponent
{
    private $action;
    private $format;
    private $language;
    private $delay;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::attribution';
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
        $metadata->addPropertyConstraints('language', [new Assert\NotBlank()]);
        $metadata->addPropertyConstraint('action', new Assert\Choice([
            'INSERT',
            'UPDATE',
            'DELETE',
        ]));
        $metadata->addPropertyConstraint('delay', new Assert\Date());
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
     * @return Attribution
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
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
     * @return Attribution
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
     * @return Attribution
     */
    public function setLanguage($language)
    {
        $this->language = $language;

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
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return $this
     */
    public function setDelay($year, $month, $day)
    {
        $date = new \DateTime();
        $this->delay = $date->setDate($year, $month, $day)->format("d/m/Y");

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromXml($xml)
    {
        // TODO: Implement fromXml() method.

        return $this;
    }
}
