<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Messages\Components\Target;

/**
 * Contains setter, getter and factory methods for "Target" component.
 *
 * @package EC\Poetry\Messages\Components\Traits
 */
trait WithTargetsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Target[]
     */
    private $targets;

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Target[]
     *   Property value.
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Setter.
     *
     * @param \EC\Poetry\Messages\Components\Target $targets
     *   Property value.
     *
     * @return $this
     */
    public function setTargets(Target $targets)
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * Factory method: create a new Target and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Target
     *      Target instance.
     */
    public function withTarget()
    {
        static $index = 0;
        $target = $this->targets[$index] = new Target();
        $index++;

        return $target;
    }
}
