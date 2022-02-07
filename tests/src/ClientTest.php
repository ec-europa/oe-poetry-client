<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Settings;
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
        $this->assertXmlFromFixture('messages/responses/response-status.xml', $rendererResponse);
    }

    /**
     * Test WSDL generation.
     */
    public function testWsdl()
    {
        $poetry = new Poetry();
        $actual = $poetry->getWsdl()->getXml();
        $this->assertStringContainsString('<soap:address location="" />', $actual);

        $poetry = new Poetry([
            'notification.endpoint' => 'http://example.com/notification/endpoint',
        ]);
        $actual = $poetry->getWsdl()->getXml();
        $this->assertStringContainsString('<soap:address location="http://example.com/notification/endpoint" />', $actual);

        $actual = $poetry->getWsdl()->getHeaders();
        $this->assertEquals([
            'content-type' => 'application/xml; utf-8',
        ], $actual);
    }
}
