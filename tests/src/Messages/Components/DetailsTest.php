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
        expect($violations->count())->to->be->above(0);

        $expected = [
          'type' => "The value you selected is not a valid choice.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            expect($violation)->to->be->equal($expected[$name]);
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
            expect($component->$method())->to->equal($value);
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/details.yml'));
    }
}
