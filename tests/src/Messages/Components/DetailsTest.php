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
     * @param string $xml
     * @param array  $expressions
     *
     * @dataProvider parserProvider
     */
    public function testWithXml($xml, $expressions)
    {
        $message = $this->getContainer()->get('component.details')->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
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
            expect($component->$method())->to->equal($value);
        }

        $component = new Details();
        $component->withArray($array);
        foreach ($expected as $method => $value) {
            expect($component->$method())->to->equal($value);
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-xml/components/details.yml'));
    }

    /**
     * @return mixed
     */
    public function withArrayProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-array/components/details.yml'));
    }
}
