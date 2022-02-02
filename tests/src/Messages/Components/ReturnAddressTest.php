<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

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
        $this->assertGreaterThan(0, $violations->count());

        $expected = [
            'address' => "This value should not be blank.",
            'password' => "The return type you selected can't have a password.",
            'path' => "The return type you selected can't have a path.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            $this->assertEquals($expected[$name], $violation);
        }
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $fixtures
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $fixtures)
    {
        /** @var \EC\Poetry\Messages\Components\ReturnAddress $component */
        $component = $this->getContainer()->get('component.return_address')->fromXml($xml);

        foreach ($fixtures as $method => $value) {
            $this->assertEquals($value, $component->$method());
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/returnAddress.yml'));
    }
}
