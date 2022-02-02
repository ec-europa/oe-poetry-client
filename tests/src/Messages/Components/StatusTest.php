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
        $this->assertGreaterThan(0, $violations->count());
        $expected = [
            'code' => "The value you selected is not a valid choice.",
        ];
        foreach ($this->getViolations($violations) as $name => $violation) {
            $this->assertEquals($expected[$name], $violation);
        }
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $date
     * @param string $time
     * @param string $message
     * @param string $code
     * @param string $type
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $date, $time, $message, $code, $type)
    {
        /** @var \EC\Poetry\Messages\Components\Status $component */
        $component = $this->getContainer()->get('component.status')->fromXml($xml);

        $this->assertEquals($date, $component->getDate());
        $this->assertEquals($time, $component->getTime());
        $this->assertEquals($message, $component->getMessage());
        $this->assertEquals($code, $component->getCode());
        $this->assertEquals($type, $component->getType());
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/status.yml'));
    }
}
