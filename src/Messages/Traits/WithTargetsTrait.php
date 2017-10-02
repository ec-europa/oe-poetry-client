<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Target;

/**
 * Contains setter, getter and factory methods for "Target" component.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait WithTargetsTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Target[]
     */
    private $targets = [];

    /**
     * Add component.
     *
     * @param Target $target
     *      Component object.
     *
     * @return $this
     */
    public function addTarget(Target $target)
    {
        $this->targets[] = $target;

        return $this;
    }
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
     * @param \EC\Poetry\Messages\Components\Target[] $targets
     *   Property value.
     *
     * @return $this
     */
    public function setTargets(array $targets)
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
        $this->targets[] = new Target();

        return end($this->targets);
    }
}
