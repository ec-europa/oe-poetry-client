<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
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
        /** @var \EC\Poetry\Messages\Responses\Status $message */
        $message = $this->getContainer()->get('response.status')->fromXml($xml);

        $statuses = $message->getStatuses();

//        expect($message->getIdentifier()->getFormattedIdentifier())->to->equal($idCode);
//        expect($statuses[0]->getCode())->to->equal($code);
//        expect($statuses[0]->getType())->to->equal($type);
//        expect($statuses[0]->getDate())->to->equal($date);
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/status.yml'));
    }
}
