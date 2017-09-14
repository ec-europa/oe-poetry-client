<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

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

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $type
     * @param string $nickname
     * @param string $email
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $type, $nickname, $email)
    {
        /** @var \EC\Poetry\Messages\Components\Contact $component */
        $component = $this->getContainer()->get('component.contact')->fromXml($xml);

        expect($component->getType())->to->equal($type);
        expect($component->getNickname())->to->equal($nickname);
        expect($component->getEmail())->to->equal($email);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/contact.yml'));
    }
}
