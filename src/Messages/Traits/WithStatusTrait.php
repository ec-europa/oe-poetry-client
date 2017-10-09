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
    public function isSuccessful()
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
        return $this->getErrors() !== [];
    }

    /**
     *  Check some statuses have warnings.
     *
     * @return boolean
     *    True if some status has warnings, false otherwise.
     */
    public function hasWarnings()
    {
        return $this->getWarnings() !== [];
    }

    /**
     *  Get statuses with errors.
     *
     * @return array
     *    Statuses with errors.
     */
    public function getErrors()
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
     * @return int
     */
    public function countErrors()
    {
        return count($this->getErrors());
    }

    /**
     *  Get statuses with warnings.
     *
     * @return array
     *    Statuses with warnings.
     */
    public function getWarnings()
    {
        $warnings = [];
        foreach ($this->getStatuses() as $status) {
            if (intval($status->getCode()) > 0) {
                $warnings[] = $status;
            }
        }

        return $warnings;
    }

    /**
     * @return int
     */
    public function countWarnings()
    {
        return count($this->getWarnings());
    }

    /**
     * @return bool
     */
    public function hasRequestStatus()
    {
        return $this->getRequestStatus() !== null;
    }

    /**
     * @return \EC\Poetry\Messages\Components\Status|null
     */
    public function getRequestStatus()
    {
        foreach ($this->getStatuses() as $status) {
            if ($status->getType() == 'request') {
                return $status;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasDemandStatus()
    {
        return $this->getDemandStatus() !== null;
    }

    /**
     * @return \EC\Poetry\Messages\Components\Status|null
     */
    public function getDemandStatus()
    {
        foreach ($this->getStatuses() as $status) {
            if ($status->getType() == 'demande') {
                return $status;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasAttributionStatuses()
    {
        return count($this->getAttributionStatuses()) > 0;
    }

    /**
     * @return array
     */
    public function getAttributionStatuses()
    {
        $statuses = [];
        foreach ($this->getStatuses() as $status) {
            if ($status->getType() == 'attribution') {
                $statuses[] = $status;
            }
        }

        return $statuses;
    }
}
