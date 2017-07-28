<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TargetParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class TargetParserTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $targetProperties
     * @param array  $returnAddressProperties
     * @param array  $contactProperties
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $targetProperties, $returnAddressProperties, $contactProperties)
    {
        /** @var \EC\Poetry\Parsers\Components\TargetParser $parser */
        /** @var \EC\Poetry\Messages\Components\Target $target */
        $parser = $this->getContainer()->get('parser.component.target');
        $components = $parser->parse($xml);
        expect(count($components))->to->be->equal(1);
        $target = $components[0];

        foreach ($targetProperties as $method => $value) {
            expect($target->$method())->to->equal($value);
        }
        expect(count($target->getReturnAddresses()))->to->equal(1);
        $returnAddress = $target->getReturnAddresses()[0];
        foreach ($returnAddressProperties as $method => $value) {
            expect($returnAddress->$method())->to->equal($value);
        }
        expect(count($target->getContacts()))->to->equal(1);
        $contact = $target->getContacts()[0];
        foreach ($contactProperties as $method => $value) {
            expect($contact->$method())->to->equal($value);
        }
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/target.yml'));
    }
}
