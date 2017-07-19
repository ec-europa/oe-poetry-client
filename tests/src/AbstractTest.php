<?php

namespace EC\Poetry\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractTest
 *
 * @package EC\Poetry\Tests
 */
abstract class AbstractTest extends TestCase
{

    /**
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $violations
     *
     * @return array
     */
    protected function getViolations(ConstraintViolationListInterface $violations)
    {
        $collection = [];
        foreach ($violations as $violation) {
            $collection[$violation->getPropertyPath() ? $violation->getPropertyPath() : 'object'] = $violation->getMessage();
        }

        return $collection;
    }
}
