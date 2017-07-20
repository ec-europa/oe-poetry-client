<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\RequestMessage;
use EC\Poetry\Messages\StatusMessage;
use EC\Poetry\Poetry;

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
        $request = new RequestMessage($this->getValidIdentifier());
        $status = new StatusMessage($this->getValidIdentifier());

        $rendererRequest = $this->getContainer()->get('renderer')->render($request);
        $rendererStatus = $this->getContainer()->get('renderer')->render($status);

        $mock = $this->getSoapClientMock();
        $receive = $method ? $method : 'requestService';
        $mock->shouldReceive($receive)
          ->withArgs([$username, $password, $rendererRequest])
          ->andReturn($rendererStatus);

        $parameters = [
          'authentication.username' => $username,
          'authentication.password' => $password,
          'soap.client' => $mock,
        ];
        if ($method) {
            $parameters['client.method'] = $method;
        }
        $poetry = new Poetry($parameters);

        $response = $poetry->getClient()->send($request);
        expect($response)->equal($rendererStatus);
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
