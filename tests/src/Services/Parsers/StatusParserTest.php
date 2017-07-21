<?php

namespace EC\Poetry\Tests\Parsers;

use EC\Poetry\Parsers\StatusParser;
use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StatusParserTest
 *
 * @package EC\Poetry\Parsers\Tests
 */
class StatusParserTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $idCode
     * @param string $code
     * @param string $type
     * @param string $date
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $idCode, $code, $type, $date)
    {
        /** @var \EC\Poetry\Parsers\StatusParser $service */
        $service = $this->getContainer()->get('parser.message.status');
        expect($service)->is->an->instanceof(StatusParser::class);
        /** @var \EC\Poetry\Messages\Status $message */
        $message = $service->parse($xml);

        expect($message->getIdentifier()->getFormattedIdentifier())->to->equal($idCode);
        expect($message->getStatuses()[0]->getCode())->to->equal($code);
        expect($message->getStatuses()[0]->getType())->to->equal($type);
        expect($message->getStatuses()[0]->getDate())->to->equal($date);
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/status.yml'));
    }
}
