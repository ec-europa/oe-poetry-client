<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use EC\Poetry\Messages\Components\Constraints as Constraint;

/**
 * Class ReferenceDocument
 *
 * @package EC\Poetry\Messages\Components
 */
class ReferenceDocument extends AbstractComponent
{
    private $language;
    private $format;
    private $type;
    private $action;
    private $name;
    private $path;
    private $size;
    private $remark;
    private $file;


    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::reference-document';
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
        $metadata->addPropertyConstraint('language', new Assert\NotBlank());
        $metadata->addPropertyConstraints('type', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'CMP',
                'PRT',
                'RAU',
                'REF',
            ]),
        ]);
        $metadata->addPropertyConstraint('action', new Assert\Choice([
            'INSERT',
            'UPDATE',
            'DELETE',
        ]));
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
            'lgCode' => $this->getLanguage(),
            'format' => $this->getFormat(),
            'type' => $this->getType(),
            'action' => $this->getAction(),
        ];

        return array_filter($attributes);
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
     * @return ReferenceDocument
     */
    public function setLanguage($language)
    {
        $this->language = $language;

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
     * @return ReferenceDocument
     */
    public function setFormat($format)
    {
        $this->format = $format;

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
     * @return ReferenceDocument
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return ReferenceDocument
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ReferenceDocument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return ReferenceDocument
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return ReferenceDocument
     */
    public function setSize($size)
    {
        $this->size = $size;

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
     * @return ReferenceDocument
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return ReferenceDocument
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setLanguage($parser->attr('lgCode'))
            ->setFormat($parser->attr('format'))
            ->setType($parser->attr('type'))
            ->setAction($parser->attr('action'))
            ->setName($parser->getContent('documentReference/documentReferenceName'))
            ->setPath($parser->getContent('documentReference/documentReferencePath'))
            ->setSize($parser->getContent('documentReference/documentReferenceSize'))
            ->setRemark($parser->getContent('documentReference/documentReferenceRemark'))
            ->setFile($parser->getContent('documentReference/documentReferenceFile'));

        return $this;
    }
}
