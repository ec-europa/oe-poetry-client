<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class IdentifierTest
 *
 * @package EC\Poetry\Messages\Components
 */
class IdentifierTest extends TestCase
{
    /**
     * Test identifier validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $identifier = (new Identifier())->setYear(1234);

        $violations = $validator->validate($identifier);
        expect($violations->count())->to->be->above(0);

        $expected = [
          'code' => "This value should not be blank.",
          'number' => "This value should not be blank.",
          'part' => "This value should not be blank.",
          'product' => "This value should not be blank.",
          'version' => "This value should not be blank.",
          'year' => "This value should be greater than 2000.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }

    /**
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $violations
     *
     * @return array
     */
    protected function getViolations(ConstraintViolationListInterface $violations)
    {
        $collection = [];
        foreach ($violations as $violation) {
            $collection[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $collection;
    }
}
