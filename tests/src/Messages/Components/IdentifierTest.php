<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;

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
          'object' => "An identifier must have a number or a sequence.",
          'part' => "This value should not be blank.",
          'product' => "This value should not be blank.",
          'version' => "This value should not be blank.",
          'year' => "This value should be greater than 2000.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }
}
