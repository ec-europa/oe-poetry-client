<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\SourceLanguage;

/**
 * Contains setter, getter and factory methods for "SourceLanguage" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithSourceLanguagesTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\SourceLanguage[]
     */
    private $sourceLanguages = [];

    /**
     * Add component.
     *
     * @param SourceLanguage $sourceLanguage
     *      Component object.
     *
     * @return $this
     */
    public function addSourceLanguage(SourceLanguage $sourceLanguage)
    {
        $this->sourceLanguages[] = $sourceLanguage;

        return $this;
    }

    /**
     * Getter.
     *
     * @return SourceLanguage[]
     */
    public function getSourceLanguages()
    {
        return $this->sourceLanguages;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\SourceLanguage[] $sourceLanguages
     *
     * @return WithSourceLanguagesTrait
     */
    public function setSourceLanguages(array $sourceLanguages)
    {
        $this->sourceLanguages = $sourceLanguages;

        return $this;
    }

    /**
     * Factory method: create a new SourceLanguage and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\SourceLanguage
     *      SourceLanguage instance.
     */
    public function withSourceLanguage()
    {
        $this->sourceLanguages[] = new SourceLanguage();

        return end($this->sourceLanguages);
    }
}
