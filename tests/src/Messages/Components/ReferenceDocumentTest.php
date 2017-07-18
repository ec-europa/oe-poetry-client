<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;

/**
 * Class ReferenceDocumentTest
 *
 * @package EC\Poetry\Messages\Components
 */
class ReferenceDocumentTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $referenceDocument = (new ReferenceDocument())->setFormat('test');
        $referenceDocument->setType('type');
        $referenceDocument->setAction('action');


        $violations = $validator->validate($referenceDocument);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'format' => "The value you selected is not a valid choice.",
            'language' => "This value should not be blank.",
            'type' => "The value you selected is not a valid choice.",
            'action' => "The value you selected is not a valid choice.",
            'name' => "This value should not be blank.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
        }
    }
}
