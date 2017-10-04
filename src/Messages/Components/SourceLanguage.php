<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Services\Parser;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use EC\Poetry\Messages\Components\Constraints as Constraint;

/**
 * Class Source
 *
 * @package EC\Poetry\Messages\Components
 */
class SourceLanguage extends AbstractComponent
{
    private $code;
    private $pages;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::source-language';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('code', new Assert\NotBlank());
        $metadata->addPropertyConstraints('pages', [
            new Assert\NotBlank(),
            new Assert\Type('int'),
        ]);
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
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     *
     * @return $this
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setCode($parser->getAttribute('documentSourceLang', 'lgCode'))
            ->setPages($parser->getContent('documentSourceLang/documentSourceLangPages'));

        return $this;
    }
}
