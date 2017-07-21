<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StatusParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class StatusParserTest extends AbstractTest
{
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
        /** @var \EC\Poetry\Parsers\Components\StatusParser $parser */
        $parser = $this->getContainer()->get('parser.status');
        $component = $parser->parse($xml);

        expect($component->getDate())->to->equal($date);
        expect($component->getTime())->to->equal($time);
        expect($component->getMessage())->to->equal($message);
        expect($component->getCode())->to->equal($code);
        expect($component->getType())->to->equal($type);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parser.status.yml'));
    }
}
