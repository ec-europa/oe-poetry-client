<?php

namespace EC\Poetry\Tests\Services\Parsers\Components;

use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ContactParserTest
 *
 * @package EC\Poetry\Tests\Services\Parsers\Components
 */
class ContactParserTest extends AbstractTest
{
    /**
     * Test parsing.
     *
     * @param string $xml
     * @param string $type
     * @param string $nickname
     * @param string $email
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $type, $nickname, $email)
    {
        /** @var \EC\Poetry\Parsers\Components\ContactParser $parser */
        /** @var \EC\Poetry\Messages\Components\Contact[] $components */
        $parser = $this->getContainer()->get('parser.component.contact');
        $components = $parser->parse($xml);
        expect(count($components))->to->be->equal(1);

        expect($components[0]->getType())->to->equal($type);
        expect($components[0]->getNickname())->to->equal($nickname);
        expect($components[0]->getEmail())->to->equal($email);
    }

    /**
     * @return mixed
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/components/contact.yml'));
    }
}
