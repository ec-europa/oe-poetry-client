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
        $this->assertGreaterThan(0, $violations->count());
        $expected = [
            'type' => "The value you selected is not a valid choice.",
            'action' => "The value you selected is not a valid choice.",
            'nickname' => "This value should not be blank.",
            'email' => "This value is not a valid email address.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            $this->assertEquals($expected[$name], $violation);
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

        $this->assertEquals($type, $component->getType());
        $this->assertEquals($nickname, $component->getNickname());
        $this->assertEquals($email, $component->getEmail());
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/contact.yml'));
    }
}
