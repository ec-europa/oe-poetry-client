<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

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
        $this->assertGreaterThan(0, $violations->count());
        $expected = [
            'format' => "The value you selected is not a valid choice.",
            'language' => "This value should not be blank.",
            'type' => "The value you selected is not a valid choice.",
            'action' => "The value you selected is not a valid choice.",
            'name' => "This value should not be blank.",
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
        /** @var \EC\Poetry\Messages\Components\ReferenceDocument $component */
        $component = $this->getContainer()->get('component.reference_document')->fromXml($xml);
        foreach ($fixtures as $method => $value) {
            $this->assertEquals($value, $component->$method());
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/referenceDocument.yml'));
    }
}
