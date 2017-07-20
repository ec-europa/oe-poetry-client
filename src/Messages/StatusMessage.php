<?php

namespace EC\Poetry\Messages;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


use EC\Poetry\Messages\Components\Status;

/**
 * Class StatusMessage
 *
 * @package EC\Poetry\Messages\Client
 */
class StatusMessage extends AbstractMessage
{
    private $statuses = [];

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraints('identifier', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addGetterConstraints('statuses', [
            new Assert\NotBlank(),
            new Assert\Valid(['traverse' => true]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'client::status';
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @param array $statuses
     *
     * @return $this
     */
    public function setStatuses($statuses)
    {
        $this->statuses = $statuses;

        return $this;
    }

    /**
     * @param mixed $status
     *
     * @return $this
     */
    public function addStatus(Status $status)
    {
        $this->statuses[] = $status;

        return $this;
    }
}
