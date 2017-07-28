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
        /** @var \EC\Poetry\Parsers\Components\StatusComponentParser $parser */
        /** @var \EC\Poetry\Messages\Components\StatusComponent[] $components */
        $parser = $this->getContainer()->get('parser.component.status');
        $components = $parser->parse($xml);
        expect(count($components))->to->be->equal(1);

        expect($components[0]->getDate())->to->equal($date);
        expect($components[0]->getTime())->to->equal($time);
        expect($components[0]->getMessage())->to->equal($message);
        expect($components[0]->getCode())->to->equal($code);
        expect($components[0]->getType())->to->equal($type);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/status.yml'));
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $firstType
     * @param string $secondType
     *
     * @dataProvider multipleParserProvider
     */
    public function testMultipleParsing($xml, $firstType, $secondType)
    {
        /** @var \EC\Poetry\Parsers\Components\StatusComponentParser $parser */
        /** @var \EC\Poetry\Messages\Components\StatusComponent[] $components */
        $parser = $this->getContainer()->get('parser.component.status');
        $components = $parser->parse($xml);
        expect(count($components))->to->be->equal(2);

        expect($components[0]->getType())->to->equal($firstType);
        expect($components[1]->getType())->to->equal($secondType);
    }

    /**
     * @return mixed
     */
    public function multipleParserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/statuses.yml'));
    }
}
