<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Source;

/**
 * Contains setter, getter and factory methods for "Source" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithSourceTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Source
     */
    protected $source;

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Source
     *   Property value.
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\Source $source
     *   Property value.
     *
     * @return $this
     */
    public function setSource(Source $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Factory method: create new details and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Source
     *      Source instance.
     */
    public function withSource()
    {
        return $this->source = new Source();
    }
}
