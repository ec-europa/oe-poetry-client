<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Notifications\StatusUpdated;
use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StatusUpdatedTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class StatusUpdatedTest extends AbstractTest
{

    /**
     * Test rendering.
     */
    public function testRender()
    {
        /** @var \EC\Poetry\Services\Renderer $renderer */
        $renderer = $this->getContainer()->get('renderer');

        $identifier = new Identifier();
        $identifier->setCode('WEB')
          ->setYear(2017)
          ->setNumber('40029')
          ->setVersion('0')
          ->setPart('0')
          ->setProduct('TRA');

        $message = new StatusUpdated($identifier);
        $message->setMessageId('1069698');
        $message->withStatus()
          ->setCode('0')
          ->setType('request')
          ->setDate('29/09/2017')
          ->setTime('15:44:02')
          ->setMessage('OK');
        $message->withStatus()
          ->setCode('ONG')
          ->setType('demande')
          ->setDate('29/09/2017')
          ->setTime('15:42:34')
          ->setMessage('REQUEST ACCEPTED');
        $message->withStatus()
          ->setCode('ONG')
          ->setType('attribution')
          ->setDate('29/09/2017')
          ->setTime('00:00:00')
          ->setLanguage('FR');
        $message->withTarget()
          ->setFormat('HTML')
          ->setLanguage('FR')
          ->setDelay('04/10/2017 23:59')
          ->setAcceptedDelay('04/10/2017 23:59');

        $output = $renderer->render($message);
        expect($output)->to->have->same->xml('messages/notifications/status-updated.xml');
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $identifier
     * @param array  $statuses
     * @param array  $targets
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $identifier, $statuses, $targets)
    {
        /** @var \EC\Poetry\Messages\Notifications\StatusUpdated $message */
        $message = $this->getContainer()->get('notification.status_updated')->fromXml($xml);

        foreach ($identifier as $method => $expected) {
            expect($message->getIdentifier()->{$method}())->to->equal($expected);
        }
        foreach ($statuses as $index => $status) {
            foreach ($status as $method => $expected) {
                expect($message->getStatuses()[$index]->{$method}())->to->equal($expected);
            }
        }
        foreach ($targets as $index => $target) {
            foreach ($target as $method => $expected) {
                expect($message->getTargets()[$index]->{$method}())->to->equal($expected);
            }
        }
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/notifications/statusUpdated.yml'));
    }
}
