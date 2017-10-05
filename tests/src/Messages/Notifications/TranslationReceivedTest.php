<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TranslationReceivedTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class TranslationReceivedTest extends AbstractTest
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
          ->setNumber('40012')
          ->setVersion('0')
          ->setPart('39')
          ->setProduct('TRA');

        $message = new TranslationReceived($identifier);
        $message->setMessageId('7685067');
        $message->withAttribution()
          ->setFormat('HTML')
          ->setLanguage('FR')
          ->setTranslatedFile('File64');

        $output = $renderer->render($message);
        expect($output)->to->have->same->xml('messages/notifications/translation-received.xml');
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $identifier
     * @param array  $attributions
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $identifier, $attributions)
    {
        /** @var \EC\Poetry\Messages\Notifications\TranslationReceived $message */
        $message = $this->getContainer()->get('notification.translation_received')->fromXml($xml);

        foreach ($identifier as $method => $expected) {
            expect($message->getIdentifier()->{$method}())->to->equal($expected);
        }
        foreach ($attributions as $index => $attribution) {
            foreach ($attribution as $method => $expected) {
                expect($message->getAttributions()[$index]->{$method}())->to->equal($expected);
            }
        }
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('parsers/notifications/translationReceived.yml'));
    }
}
