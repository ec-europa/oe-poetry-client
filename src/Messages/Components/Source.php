<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Services\Parser;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Source
 *
 * @package EC\Poetry\Messages\Components
 */
class Source extends AbstractComponent
{
    private $format;
    private $legiswriteFormat;
    private $trackChanges;
    private $channel;
    private $confidential;
    private $deadline;
    private $deadlineStatus;
    private $name;
    private $path;
    private $languages;
    private $size;
    private $file;


    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::source';
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
        $metadata->addPropertyConstraints('legiswriteFormat', [
            new Assert\NotBlank(),
            new Assert\Choice(['Yes', 'No']),
        ]);
        $metadata->addPropertyConstraint('trackChanges', new Assert\Choice(['Yes', 'No']));
        $metadata->addPropertyConstraint('channel', new Assert\Choice([
            'POETRY',
            'RUE',
            'USB',
            'PAPER',
        ]));
        $metadata->addPropertyConstraint('confidential', new Assert\Choice(['Yes', 'No']));
        $metadata->addPropertyConstraint('deadline', new Assert\DateTime());
        $metadata->addPropertyConstraint('deadlineStatus', new Assert\Choice([
            'PUBLIC',
            'DELETED',
        ]));
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('file', new Assert\NotBlank());
        $metadata->addPropertyConstraint('languages', new Assert\Count([
            'min' => 0,
            'max' => 5,
            'maxMessage' => 'Only 5 source languages are allowed.',
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
            'channel' => $this->getChannel(),
            'dealine' => $this->getDeadline(),
            'statusDealine' => $this->getDeadlineStatus(),
            'marked' => $this->getConfidential(),
            'format' => $this->getFormat(),
            'legiswrite' => $this->getLegiswriteFormat(),
            'trackChanges' => $this->getTrackChanges(),
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
     * @return Source
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLegiswriteFormat()
    {
        return $this->legiswriteFormat;
    }

    /**
     * @param mixed $legiswriteFormat
     * @return Source
     */
    public function setLegiswriteFormat($legiswriteFormat)
    {
        $this->legiswriteFormat = $legiswriteFormat;

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
     * @return Source
     */
    public function setTrackChanges($trackChanges)
    {
        $this->trackChanges = $trackChanges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param mixed $channel
     * @return Source
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfidential()
    {
        return $this->confidential;
    }

    /**
     * @param mixed $confidential
     * @return Source
     */
    public function setConfidential($confidential)
    {
        $this->confidential = $confidential;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     * @return Source
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeadlineStatus()
    {
        return $this->deadlineStatus;
    }

    /**
     * @param mixed $deadlineStatus
     * @return Source
     */
    public function setDeadlineStatus($deadlineStatus)
    {
        $this->deadlineStatus = $deadlineStatus;

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
     * @return Source
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
     * @return Source
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param array $languages
     * @return Source
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * @param mixed $code
     * @param mixed $pageCount
     * @return Source
     */
    public function addLanguage($code, $pageCount)
    {
        $this->languages[$code] = $pageCount;

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
     * @return Source
     */
    public function setSize($size)
    {
        $this->size = $size;

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
     * @return Source
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setChannel($parser->getAttribute('documentSource', 'channel'))
            ->setDeadline($parser->getAttribute('documentSource', 'deadline'))
            ->setDeadlineStatus($parser->getAttribute('documentSource', 'statusDeadline'))
            ->setConfidential($parser->getAttribute('documentSource', 'marked'))
            ->setFormat($parser->getAttribute('documentSource', 'format'))
            ->setLegiswriteFormat($parser->getAttribute('documentSource', 'legiswrite'))
            ->setTrackChanges($parser->getAttribute('documentSource', 'trackChanges'))
            ->setName($parser->getContent('documentSource/documentSourceName'))
            ->setPath($parser->getContent('documentSource/documentSourcePath'))
            ->setSize($parser->getContent('documentSource/documentSourceSize'))
            ->setFile($parser->getContent('documentSource/documentSourceFile'));

        $languages = [];
        $parser->filterXPath("documentSource/documentSourceLang")->each(function (Parser $language) use (&$languages) {
            $languages[$language->getAttribute('documentSourceLang', 'lgCode')] = $language->getContent('documentSourceLang/documentSourceLangPages');
        });
        $this->setLanguages($languages);

        return $this;
    }
}
