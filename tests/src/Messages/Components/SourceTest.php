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
        $source = (new Source());
        $source->withSourceLanguage()->setCode('en')->setPages(1);
        $source->withSourceLanguage()->setCode('fr')->setPages(1);
        $source->withSourceLanguage()->setCode('de')->setPages(1);
        $source->withSourceLanguage()->setCode('es')->setPages(1);
        $source->withSourceLanguage()->setCode('pt')->setPages(1);
        $source->withSourceLanguage()->setCode('it')->setPages(1);

        $violations = $validator->validate($source);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'format' => "This value should not be blank.",
            'legiswriteFormat' => "This value should not be blank.",
            'name' => "This value should not be blank.",
            'file' => "This value should not be blank.",
        ];
        $violations = $this->getViolations($violations);
        foreach ($expected as $name => $violation) {
            expect($violations[$name])->to->be->equal($violation);
        }
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $expected
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $expected)
    {
        /** @var \EC\Poetry\Messages\Components\Source $component */
        $component = $this->getContainer()->get('component.source')->fromXml($xml);

        foreach ($expected as $getComponent => $properties) {
            if ($this->isComponentCollection($properties)) {
                foreach ($properties as $i => $property) {
                    $this->assertProperties($component->$getComponent()[$i], $property);
                }
            } else {
                expect($component->$getComponent())->to->equal($properties);
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
