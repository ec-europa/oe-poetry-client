<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
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
     * @param string $xml
     * @param array  $expressions
     *
     * @dataProvider parserProvider
     */
    public function testWithXml($xml, $expressions)
    {
        $message = $this->getContainer()->get('response.status')->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-xml/responses/status.yml'));
    }
}
