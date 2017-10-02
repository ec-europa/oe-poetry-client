<?php

namespace EC\Poetry\Messages\Traits;

use EC\Poetry\Messages\MessageInterface;
use EC\Poetry\Services\Parser;

/**
 * Trait MessageAwareTrait.
 *
 * @package EC\Poetry\Messages\Traits
 */
trait MessageAwareTrait
{
    /**
     * @var \EC\Poetry\Messages\MessageInterface
     */
    protected $message = null;

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMessage()
    {
        return $this->message !== null;
    }
}
