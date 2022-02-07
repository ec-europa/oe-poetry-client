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
        $this->assertGreaterThan(0, $violations->count());

        $expected = [
            'code' => "This value should not be blank.",
            'part' => "This value should not be blank.",
            'product' => "This value should not be blank.",
            'version' => "This value should not be blank.",
            'year' => "This value should be greater than 2000.",
        ];
        $violations = $this->getViolations($violations);
        foreach ($expected as $name => $violation) {
            $this->assertEquals($violation, $violations[$name]);
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

        $this->assertEquals($code, $component->getCode());
        $this->assertEquals($year, $component->getYear());
        $this->assertEquals($number, $component->getNumber());
        $this->assertEquals($version, $component->getVersion());
        $this->assertEquals($part, $component->getPart());
        $this->assertEquals($product, $component->getProduct());
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
        $this->assertEquals('STS/2017/NEXT_EUROPA_COUNTER/0/0/TRA', $actual);

        $message = $poetry->get('request.create_translation_request');
        $rendered = $poetry->getRenderer()->render($message);
        $this->assertStringContainsString('<sequence>NEXT_EUROPA_COUNTER</sequence>', $rendered);
        $this->assertStringNotContainsString('<numero>', $rendered);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/identifier.yml'));
    }
}
