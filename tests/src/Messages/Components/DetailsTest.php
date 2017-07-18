<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;

/**
 * Class DetailsTest
 *
 * @package EC\Poetry\Messages\Components
 */
class DetailsTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $details = (new Details())->setType('TEST');

        $violations = $validator->validate($details);
        expect($violations->count())->to->be->above(0);

        $expected = [
          'type' => "The value you selected is not a valid choice.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }
}
