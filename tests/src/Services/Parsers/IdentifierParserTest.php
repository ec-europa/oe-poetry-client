<?php

namespace EC\Poetry\Tests\Services\Parsers;

use EC\Poetry\Tests\AbstractTest;

/**
 * Class IdentifierParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers
 */
class IdentifierParserTest extends AbstractTest
{
    /**
     * Test parsing.
     */
    public function testParsing()
    {
        /** @var \EC\Poetry\Services\Parsers\IdentifierParser $parser */
        $parser = $this->getContainer()->get('parser.identifier');
        $xml = $this->getFixture('message.status.xml');
        $component = $parser->parse($xml);

        expect($component->getCode())->to->equal('DGT');
        expect($component->getYear())->to->equal('2017');
        expect($component->getNumber())->to->equal('0001');
        expect($component->getVersion())->to->equal('01');
        expect($component->getPart())->to->equal('00');
        expect($component->getProduct())->to->equal('ABC');
    }
}
