<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Details;

/**
 * Contains setter, getter and factory methods for "Details" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithDetailsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Details
     */
    protected $details;

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Details
     *   Property value.
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\Details $details
     *   Property value.
     *
     * @return $this
     */
    public function setDetails(Details $details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Factory method: create new details and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Details
     *      Details instance.
     */
    public function withDetails()
    {
        return $this->details = new Details();
    }
}
