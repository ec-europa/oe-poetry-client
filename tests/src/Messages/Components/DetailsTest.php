<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

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
        $this->assertGreaterThan(0, $violations->count());

        $expected = [
            'type' => "The value you selected is not a valid choice.",
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
        /** @var \EC\Poetry\Messages\Components\Details $component */
        $component = $this->getContainer()->get('component.details')->fromXml($xml);

        foreach ($fixtures as $method => $value) {
            $this->assertEquals($value, $component->$method());
        }
    }

    /**
     * @param array $array
     * @param array $expected
     *
     * @dataProvider withArrayProvider
     */
    public function testWithArray(array $array, array $expected)
    {
        $component = new Details();
        foreach ($array as $name => $value) {
            $component[$name] = $value;
        }

        foreach ($expected as $method => $value) {
            $this->assertEquals($value, $component->$method());
        }

        $component = new Details();
        $component->withArray($array);
        foreach ($expected as $method => $value) {
            $this->assertEquals($value, $component->$method());
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/details.yml'));
    }

    /**
     * @return mixed
     */
    public function withArrayProvider()
    {
        return Yaml::parse($this->getFixture('arrays/components/details.yml'));
    }
}
