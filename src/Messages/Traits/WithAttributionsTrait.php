<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Attribution;

/**
 * Contains setter, getter and factory methods for "Attribution" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithAttributionsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Attribution[]
     */
    private $attributions = [];

    /**
     * Add component.
     *
     * @param Attribution $attribution
     *      Component object.
     *
     * @return $this
     */
    public function addAttribution(Attribution $attribution)
    {
        $this->attributions[] = $attribution;

        return $this;
    }
    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Attribution[]
     *   Property value.
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\Attribution[] $attributions
     *   Property value.
     *
     * @return $this
     */
    public function setAttributions(array $attributions)
    {
        $this->attributions = $attributions;

        return $this;
    }

    /**
     * Factory method: create a new Attribution and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Attribution
     *      Attribution instance.
     */
    public function withAttribution()
    {
        $this->attributions[] = new Attribution();

        return end($this->attributions);
    }
}
