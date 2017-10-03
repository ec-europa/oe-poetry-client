<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

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
        $source->withReturnAddress()->setType('type');
        $source->withContact()->setType('user');


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
     * Test parsing.
     *
     * @param string $xml
     * @param array  $targetProperties
     * @param array  $addressProperties
     * @param array  $contactProperties
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $targetProperties, $addressProperties, $contactProperties)
    {
        /** @var \EC\Poetry\Messages\Components\Target $target */
        $target = $this->getContainer()->get('component.target')->fromXml($xml);

        foreach ($targetProperties as $method => $value) {
            expect($target->$method())->to->equal($value);
        }
        $returnAddress = $target->getReturnAddresses()[0];
        foreach ($addressProperties as $method => $value) {
            expect($returnAddress->$method())->to->equal($value);
        }
        expect(count($target->getContacts()))->to->equal(1);
        $contact = $target->getContacts()[0];
        foreach ($contactProperties as $method => $value) {
            expect($contact->$method())->to->equal($value);
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/target.yml'));
    }
}
