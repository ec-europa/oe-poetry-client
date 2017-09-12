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
        $rendererStatus = $this->getContainer()->get('renderer')->render($status);

        $mock = $this->getSoapClientMock();
        $receive = $method ? $method : 'requestService';
        $mock->shouldReceive($receive)
          ->withArgs([$username, $password, $rendererRequest])
          ->andReturn($rendererStatus);

        $logger = new TestLogger();
        $parameters = [
          'authentication.username' => $username,
          'authentication.password' => $password,
          'soap.client' => $mock,
          'logger' => $logger,
        ];
        if ($method) {
            $parameters['client.method'] = $method;
        }
        $poetry = new Poetry($parameters);

        $response = $poetry->getClient()->send($request);
        expect($response)->equal($rendererStatus);

        $logs = $logger->getLogs();

        expect($logs[LogLevel::CRITICAL])->to->be->empty();
        expect($logs[LogLevel::INFO])->to->be->not->empty();
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
