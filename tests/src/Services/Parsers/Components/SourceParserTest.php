<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SourceParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class SourceParserTest extends AbstractTest
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
        /** @var \EC\Poetry\Parsers\Components\SourceParser $parser */
        $parser = $this->getContainer()->get('parser.component.source');
        $component = $parser->parse($xml);

        foreach ($fixtures as $method => $value) {
            if (is_array($value)) {
                expect($component->$method())->to->keys($value);
            } else {
                expect($component->$method())->to->equal($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/source.yml'));
    }
}
