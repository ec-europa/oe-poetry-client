<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Events\ParseNotificationEvent;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\Logger\TestLogger;
use Psr\Log\LogLevel;

/**
 * Class ClientTest
 *
 * @package EC\Poetry\Tests
 */
class ClientTest extends AbstractTest
{
    /**
     * Test send method.
     */
    public function testSend()
    {
        $request = new CreateTranslationRequest($this->getValidIdentifier(), new Settings());
        $username = 'foo';
        $password = 'bar';

        $rendererRequest = $this->getContainer()->get('renderer')->render($request);

        $mock = $this->getSoapClientMock();
        $mock->shouldReceive('requestService')
          ->withArgs([$username, $password, $rendererRequest])
          ->andReturn($this->getFixture('messages/responses/response-status.xml'));

        $parameters = [
          'service.username' => $username,
          'service.password' => $password,
          'soap_client' => $mock,
          'log_level' => LogLevel::INFO,
        ];
        $poetry = new Poetry($parameters);

        $response = $poetry->getClient()->send($request);
        $rendererResponse = $this->getContainer()->get('renderer')->render($response);
        expect($rendererResponse)->has->same->xml('messages/responses/response-status.xml');
    }

    /**
     * Test WSDL generation.
     */
    public function testWsdl()
    {
        $poetry = new Poetry();
        $actual = $poetry->getWsdl()->getXml();
        expect($actual)->to->contain('<soap:address location="" />');

        $poetry = new Poetry([
            'notification.endpoint' => 'http://example.com/notification/endpoint',
        ]);
        $actual = $poetry->getWsdl()->getXml();
        expect($actual)->to->contain('<soap:address location="http://example.com/notification/endpoint" />');

        $actual = $poetry->getWsdl()->getHeaders();
        expect($actual)->to->equal([
            'content-type' => 'application/xml; utf-8',
        ]);
    }
}
