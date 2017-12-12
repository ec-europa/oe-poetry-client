<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\Traits\WithSourceLanguagesTrait;
use EC\Poetry\Services\Parser;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use EC\Poetry\Messages\Components\Constraints as Constraint;

/**
 * Class Source
 *
 * @package EC\Poetry\Messages\Components
 */
class Source extends AbstractComponent
{
    use WithSourceLanguagesTrait;

    private $format;
    private $legiswriteFormat;
    private $trackChanges;
    private $channel;
    private $confidential;
    private $deadline;
    private $deadlineStatus;
    private $name;
    private $path;
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
            new Constraint\DocumentFormat(),
        ]);
        $metadata->addPropertyConstraints('legiswriteFormat', [
            new Assert\NotBlank(),
            new Constraint\YesNo(),
        ]);
        $metadata->addPropertyConstraint('trackChanges', new Constraint\YesNo());
        $metadata->addPropertyConstraint('channel', new Constraint\SourceChannel());
        $metadata->addPropertyConstraint('confidential', new Constraint\YesNo());
        $metadata->addPropertyConstraint('deadlineStatus', new Constraint\SourceDeadlineStatus());
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('file', new Assert\NotBlank());
        $metadata->addPropertyConstraints('sourceLanguages', [
            new Assert\Count([
                'min' => 0,
                'max' => 5,
                'maxMessage' => 'Only 5 source languages are allowed.',
            ]),
            new Assert\Valid(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
            'channel' => $this->getChannel(),
            'deadline' => $this->getDeadline(),
            'statusDeadline' => $this->getDeadlineStatus(),
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
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);
        $this->parseDocumentSource($parser);
        $this->parseSourceLanguage($parser);

        return $this;
    }

  /**
   * @param \EC\Poetry\Services\Parser $parser
   */
    private function parseSourceLanguage(Parser $parser)
    {
        $parser->eachComponent("documentSource/documentSourceLang", function (Parser $language) {
            $this->withSourceLanguage()
            ->setParser($this->getParser())
            ->fromXml($language->outerHtml());
        }, $this);
    }

    /**
     * @param \EC\Poetry\Services\Parser $parser
     */
    private function parseDocumentSource(Parser $parser)
    {
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
    }
}
