<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\Components\Status;
use EC\Poetry\Poetry;

/**
 * Contains setter, getter and factory methods for "Status" component.
 *
 * @package EC\Poetry\Messages\Traits
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

    /**
     *  Check if all statuses are successful.
     *
     * @return boolean
     *    True if there are no errors neither warnings, false otherwise.
     */
    public function isSuccess()
    {
        return !$this->hasWarnings() && !$this->hasErrors();
    }

    /**
     *  Check some statuses have errors.
     *
     * @return boolean
     *    True if some status has errors, false otherwise.
     */
    public function hasErrors()
    {
        return $this->getStatusesWithErrors() !== [];
    }

    /**
     *  Check some statuses have warnings.
     *
     * @return boolean
     *    True if some status has warnings, false otherwise.
     */
    public function hasWarnings()
    {
        return $this->getStatusesWithWarnings() !== [];
    }

    /**
     *  Get statuses with errors.
     *
     * @return array
     *    Statuses with errors.
     */
    public function getStatusesWithErrors()
    {
        $errors = [];
        foreach ($this->getStatuses() as $status) {
            if (intval($status->getCode()) < 0) {
                $errors[] = $status;
            }
        }

        return $errors;
    }

    /**
     *  Get statuses with warnings.
     *
     * @return array
     *    Statuses with warnings.
     */
    public function getStatusesWithWarnings()
    {
        $warnings = [];
        foreach ($this->getStatuses() as $status) {
            if (intval($status->getCode()) > 0) {
                $warnings[] = $status;
            }
        }

        return $warnings;
    }
}
