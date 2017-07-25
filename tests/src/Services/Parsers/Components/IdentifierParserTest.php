<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class IdentifierParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class IdentifierParserTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $code
     * @param string $year
     * @param string $number
     * @param string $version
     * @param string $part
     * @param string $product
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $code, $year, $number, $version, $part, $product)
    {
        /** @var \EC\Poetry\Parsers\Components\IdentifierParser $parser */
        /** @var \EC\Poetry\Messages\Components\Identifier $component */
        $parser = $this->getContainer()->get('parser.component.identifier');
        $component = $parser->parse($xml);

        expect($component->getCode())->to->equal($code);
        expect($component->getYear())->to->equal($year);
        expect($component->getNumber())->to->equal($number);
        expect($component->getVersion())->to->equal($version);
        expect($component->getPart())->to->equal($part);
        expect($component->getProduct())->to->equal($product);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/identifier.yml'));
    }
}
