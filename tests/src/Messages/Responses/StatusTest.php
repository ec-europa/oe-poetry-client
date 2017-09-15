<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Parsers\StatusParser;
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
            expect($message->getIdentifier()->{$method}())->to->equal($expected);
        }
        foreach ($statuses as $index => $status) {
            foreach ($status as $method => $expected) {
                expect($message->getStatuses()[$index]->{$method}())->to->equal($expected);
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
}