<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SourceTest
 *
 * @package EC\Poetry\Messages\Components
 */
class SourceTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $source = (new Source())->addLanguage('en', 1);
        $source->addLanguage('fr', 1);
        $source->addLanguage('de', 1);
        $source->addLanguage('es', 1);
        $source->addLanguage('pt', 1);
        $source->addLanguage('it', 1);

        $violations = $validator->validate($source);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'format' => "This value should not be blank.",
            'legiswriteFormat' => "This value should not be blank.",
            'name' => "This value should not be blank.",
            'file' => "This value should not be blank.",
            'languages' => "Only 5 source languages are allowed.",
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
        /** @var \EC\Poetry\Messages\Components\Source $component */
        $component = $this->getContainer()->get('component.source')->fromXml($xml);

        foreach ($fixtures as $method => $value) {
            if (is_array($value)) {
                expect($component->$method())->to->keys($value);
            } else {
                expect($component->$method())->to->equal($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/source.yml'));
    }
}
