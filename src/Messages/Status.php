<?php

namespace EC\Poetry\Messages;

use EC\Poetry\Messages\Components\StatusComponent;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StatusComponent
 *
 * @package EC\Poetry\Messages\Client
 */
class Status extends AbstractMessage
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
        return 'messages::status';
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
    public function addStatus(StatusComponent $status)
    {
        $this->statuses[] = $status;

        return $this;
    }
}
