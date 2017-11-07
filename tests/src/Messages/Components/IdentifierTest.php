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
     * @param string $xml
     * @param array  $expressions
     *
     * @dataProvider parserProvider
     */
    public function testWithXml($xml, $expressions)
    {
        /** @var \EC\Poetry\Messages\Responses\Status $message */
        $message = $this->getContainer()
          ->get('component.identifier')
          ->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
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
        return Yaml::parse($this->getFixture('factories/with-xml/components/identifier.yml'));
    }
}
