<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DetailsParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class DetailsParserTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $fixtures
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $fixtures)
    {
        /** @var \EC\Poetry\Parsers\Components\DetailsParser $parser */
        $parser = $this->getContainer()->get('parser.component.details');
        $component = $parser->parse($xml);

        foreach ($fixtures as $method => $value) {
            expect($component->$method())->to->equal($value);
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/details.yml'));
    }
}
