<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Poetry;
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
     * @param string $username
     * @param string $password
     * @param string $method
     *
     * @dataProvider clientParametersProvider
     */
    public function testSend($username, $password, $method)
    {
        $request = new CreateRequest($this->getValidIdentifier());
        $status = new Status($this->getValidIdentifier());

        $rendererRequest = $this->getContainer()->get('renderer')->render($request);

        $mock = $this->getSoapClientMock();
        $receive = $method ? $method : 'requestService';
        $mock->shouldReceive($receive)
          ->withArgs([$username, $password, $rendererRequest])
          ->andReturn($this->getFixture('messages/response-status-1.xml'));

        $logger = new TestLogger();
        $parameters = [
          'service.username' => $username,
          'service.password' => $password,
          'soap_client' => $mock,
          'logger' => $logger,
        ];
        if ($method) {
            $parameters['client.method'] = $method;
        }
        $poetry = new Poetry($parameters);

        $response = $poetry->getClient()->send($request);
        $rendererResponse = $this->getContainer()->get('renderer')->render($response);
        expect($rendererResponse)->has->same->xml('messages/response-status-1.xml');

        $logs = $logger->getLogs();

        expect($logs[LogLevel::CRITICAL])->to->be->empty();
        expect($logs[LogLevel::INFO])->to->be->not->empty();
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

    /**
     * @return array
     */
    public function clientParametersProvider()
    {
        return [
          ['john', 'smith', null],
          ['john', 'smith', 'overriddenRequestService'],
        ];
    }
}
