<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class TargetTest
 *
 * @package EC\Poetry\Messages\Components
 */
class TargetTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $source = (new Target())->setFormat('document');
        $source->setTrackChanges('maybe');
        $source->setAction('READ');
        $source->setDelay('date');
        $source->setAcceptedDelay('date');
        $source->addReturnAddress((new ReturnAddress())->setType('type'));
        $source->addContact((new Contact())->setType('user'));


        $violations = $validator->validate($source);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'format' => "The value you selected is not a valid choice.",
            'language' => "This value should not be blank.",
            'trackChanges' => "The value you selected is not a valid choice.",
            'action' => "The value you selected is not a valid choice.",
            'delay' => "This value is not a valid datetime.",
            'acceptedDelay' => "This value is not a valid datetime.",
            'returnAddresses[0].type' => "The value you selected is not a valid choice.",
            'returnAddresses[0].address' => "This value should not be blank.",
            'returnAddresses[0].password' => "The return type you selected can't have a password.",
            'returnAddresses[0].path' => "The return type you selected can't have a path.",
            'contacts[0].type' => "The value you selected is not a valid choice.",
            'contacts[0].nickname' => "This value should not be blank.",

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
