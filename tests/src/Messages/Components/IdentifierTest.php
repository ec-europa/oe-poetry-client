<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Messages\Requests\CreateReviewRequest;
use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class IdentifierTest
 *
 * @package EC\Poetry\Messages\Components
 */
class IdentifierTest extends TestCase
{
    /**
     * Test identifier validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $identifier = (new Identifier())->setYear(1017);

        $violations = $validator->validate($identifier);
        expect($violations->count())->to->be->above(0);

        $expected = [
          'code' => "This value should not be blank.",
          'part' => "This value should not be blank.",
          'product' => "This value should not be blank.",
          'version' => "This value should not be blank.",
          'year' => "This value should be greater than 2000.",
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
     * @param string $code
     * @param string $year
     * @param string $number
     * @param string $version
     * @param string $part
     * @param string $product
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $code, $year, $number, $version, $part, $product)
    {
        /** @var \EC\Poetry\Messages\Components\Identifier $component */
        $component = $this->getContainer()->get('component.identifier')->fromXml($xml);

        expect($component->getCode())->to->equal($code);
        expect($component->getYear())->to->equal($year);
        expect($component->getNumber())->to->equal($number);
        expect($component->getVersion())->to->equal($version);
        expect($component->getPart())->to->equal($part);
        expect($component->getProduct())->to->equal($product);
    }

    /**
     * Test identifier validation.
     */
    public function testSequence()
    {
        $poetry = new Poetry([
            'identifier.code' => 'STS',
            'identifier.year' => '2017',
            'identifier.sequence' => 'NEXT_EUROPA_COUNTER',
            'identifier.version' => 0,
            'identifier.part' => 0,
            'identifier.product' => 'TRA',
        ]);

        $actual = $poetry->getIdentifier()->getFormattedIdentifier();
        expect($actual)->to->equal('STS/2017/NEXT_EUROPA_COUNTER/0/0/TRA');

        $message = $poetry->get('request.create_translation_request');
        $rendered = $poetry->getRenderer()->render($message);
        expect($rendered)
          ->to->contain('<sequence>NEXT_EUROPA_COUNTER</sequence>')
          ->and->not->to->contain('<numero>');
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/identifier.yml'));
    }
}
