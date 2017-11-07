<?php

namespace EC\Poetry\Messages\Components;

use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ReturnAddressTest
 *
 * @package EC\Poetry\Messages\Components
 */
class ReturnAddressTest extends TestCase
{
    /**
     * Test details validation.
     */
    public function testValidation()
    {
        /** @var \Symfony\Component\Validator\Validator\RecursiveValidator $validator */
        $validator = (new Poetry())->get('validator');
        $returnAddress = (new ReturnAddress())->setType('email');
        $returnAddress->setPassword('PASSWORD');

        $violations = $validator->validate($returnAddress);
        expect($violations->count())->to->be->above(0);

        $expected = [
            'address' => "This value should not be blank.",
            'password' => "The return type you selected can't have a password.",
            'path' => "The return type you selected can't have a path.",
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
        $message = $this->getContainer()->get('component.return_address')->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-xml/components/return-address.yml'));
    }
}
