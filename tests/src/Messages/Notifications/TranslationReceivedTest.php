<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
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
        expect($output)->to->have->same->xml('messages/notifications/translation-received.xml');
    }

    /**
     * @param string $xml
     * @param array  $expressions
     *
     * @dataProvider parserProvider
     */
    public function testWithXml($xml, $expressions)
    {
        $message = $this->getContainer()->get('notification.translation_received')->withXml($xml);
        $this->assertExpressions($expressions, ['message' => $message]);
    }

    /**
     * @return array
     */
    public function parserProvider()
    {
        return Yaml::parse($this->getFixture('factories/with-xml/notifications/translation-received.yml'));
    }
}
