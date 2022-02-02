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
        $message->withTarget()
            ->setFormat('HTML')
            ->setLanguage('FR')
            ->setTranslatedFile('File64');

        $output = $renderer->render($message);
        $this->assertXmlFromFixture('messages/notifications/translation-received.xml', $output);
    }

    /**
     * Test parsing.
     *
     * @param string $xml
     * @param array  $identifier
     * @param array  $targets
     *
     * @dataProvider parserProvider
     */
    public function testParsing($xml, $identifier, $targets)
    {
        /** @var \EC\Poetry\Messages\Notifications\TranslationReceived $message */
        $message = $this->getContainer()->get('notification.translation_received')->fromXml($xml);

        foreach ($identifier as $method => $expected) {
            $this->assertEquals($expected, $message->getIdentifier()->{$method}());
        }
        foreach ($targets as $index => $target) {
            foreach ($target as $method => $expected) {
                $this->assertEquals($expected, $message->getTargets()[$index]->{$method}());
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
