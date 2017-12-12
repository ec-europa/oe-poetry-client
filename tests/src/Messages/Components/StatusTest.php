<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StatusTest
 *
 * @package EC\Poetry\Messages\Components
 */
class StatusTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $status = (new Status())->setType('demande');
        $status->setCode(1);

        $violations = $validator->validate($status);
        expect($violations->count())->to->be->above(0);
        $expected = [
            'code' => "The value you selected is not a valid choice.",
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
        $message = $this->getContainer()->get('component.status')->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-xml/components/status.yml'));
    }
}
