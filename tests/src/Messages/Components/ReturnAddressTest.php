<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;

/**
 * Class ReturnAddressTest
 *
 * @package EC\Poetry\Messages\Components
 */
class ReturnAddressTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $returnAddress = (new ReturnAddress())->setType('email');
        $returnAddress->setPassword('PASSWORD');

        $violations = $validator->validate($returnAddress);
        expect($violations->count())->to->be->above(0);

        $expected = [
            'address' => "This value should not be blank.",
            'password' => "The return type you selected can't have a password.",
            'path' => "The return type you selected can't have a path.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }
}
