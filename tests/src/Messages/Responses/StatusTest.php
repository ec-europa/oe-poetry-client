<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StatusTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class StatusTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $identifier
     * @param array  $statuses
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $identifier, $statuses)
    {
        /** @var \EC\Poetry\Messages\Responses\Status $message */
        $message = $this->getContainer()->get('response.status')->fromXml($xml);

        foreach ($identifier as $method => $expected) {
            $this->assertEquals($expected, $message->getIdentifier()->{$method}());
        }
        foreach ($statuses as $index => $status) {
            foreach ($status as $method => $expected) {
                $this->assertEquals($expected, $message->getStatuses()[$index]->{$method}());
            }
        }
    }

    /**
     * Test validation.
     *
     * @param string $xml
     * @param array  $expectations
     *
     * @dataProvider statusProvider
     */
    public function testValidation($xml, array $expectations)
    {
        /** @var \EC\Poetry\Messages\Responses\Status $message */
        $message = $this->getContainer()->get('response.status')->fromXml($xml);
        foreach ($expectations as $method => $result) {
            if (is_array($result) && is_numeric(key($result))) {
                foreach ($result as $key => $values) {
                    $object = $message->$method()[$key];
                    foreach ($values as $method => $result) {
                        $this->assertEquals($result, $object->$method());
                    }
                }
            } elseif (is_array($result) && !is_numeric(key($result))) {
                $object = $message->$method();
                foreach ($result as $key => $value) {
                    $this->assertEquals($value, $object->$key());
                }
            } else {
                $this->assertEquals($result, $message->$method());
            }
        }
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/status.yml'));
    }

    /**
     * @return array
     */
    public function statusProvider()
    {
        return Yaml::parse($this->getFixture('status.yml'));
    }
}
