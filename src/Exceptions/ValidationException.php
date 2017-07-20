<?php

namespace EC\Poetry\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException
 *
 * @package EC\Poetry\Exceptions
 */
class ValidationException extends PoetryException
{
    /**
     * @var \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    private $violations;

    /**
     * ValidationException constructor.
     *
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        $message = implode(PHP_EOL, $this->getMessages());
        parent::__construct($message);
    }

    /**
     * Get Messages property.
     *
     * @return string[]
     *   Property value.
     */
    public function getMessages()
    {
        /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
        $messages = [];
        foreach ($this->violations as $violation) {
            $messages[] = $violation->getPropertyPath().': '.$violation->getMessage();
        }

        return $messages;
    }
}
