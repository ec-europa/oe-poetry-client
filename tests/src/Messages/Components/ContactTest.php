<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;

/**
 * Class ContactTest
 *
 * @package EC\Poetry\Messages\Components
 */
class ContactTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $contact = (new Contact())->setType('test');
        $contact->setAction('action');
        $contact->setEmail('email');


        $violations = $validator->validate($contact);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'type' => "The value you selected is not a valid choice.",
            'action' => "The value you selected is not a valid choice.",
            'nickname' => "This value should not be blank.",
            'email' => "This value is not a valid email address.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }
}
