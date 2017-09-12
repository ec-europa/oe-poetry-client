<?php

namespace EC\Poetry\Messages\Components\Traits;

use EC\Poetry\Messages\Components\Status;

/**
 * Contains setter, getter and factory methods for "Status" component.
 *
 * @package EC\Poetry\Messages\Components\Traits
 */
trait WithStatusTrait
{
    /**
     * @var \EC\Poetry\Messages\Components\Status[]
     */
    private $statuses = [];

    /**
     * Getter.
     *
     * @return \EC\Poetry\Messages\Components\Status[]
     *   Property value.
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Set components.
     *
     * @param \EC\Poetry\Messages\Components\Status[] $statuses
     *      List of component instances.
     *
     * @return $this
     */
    public function setStatuses(array $statuses)
    {
        $this->statuses = $statuses;

        return $this;
    }

    /**
     * Add component.
     *
     * @param \EC\Poetry\Messages\Components\Status $status
     *   Component instance.
     *
     * @return $this
     */
    public function addStatus(Status $status)
    {
        $this->statuses[] = $status;

        return $this;
    }

    /**
     * Factory method: create a new Status and return its instance.
     *
     * @return \EC\Poetry\Messages\Components\Status
     *      Status instance.
     */
    public function withStatus()
    {
        $this->statuses[] = new Status();

        return end($this->statuses);
    }
}
