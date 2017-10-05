<?php

namespace EC\Poetry\Tests\Services;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractTest;
use EC\Poetry\Tests\Logger\TestLogger;
use Psr\Log\LogLevel;

/**
 * Class LoggerSubscriberTest
 *
 * @package EC\Poetry\Tests\Services
 */
class LoggerSubscriberTest extends AbstractTest
{
    /**
     * Test client logging.
     */
    public function testClientLogging()
    {
        $response = $this->getFixture('messages/responses/response-status.xml');
        $request = new CreateRequest($this->getValidIdentifier(), new Settings());
        $mock = $this->getSoapClientMock();
        $mock->shouldReceive('requestService')->andReturn($response);

        $logger = new TestLogger();
        $poetry = new Poetry([
            'service.username' => 'username',
            'service.password' => 'password',
            'soap_client' => $mock,
            'logger' => $logger,
        ]);

        $poetry->getClient()->send($request);
        $logs = $logger->getLogs()[LogLevel::INFO];

        expect($logs)->to->have->keys([
            'poetry.client.request',
            'poetry.client.response',
            'poetry.response.parse',
        ]);
        expect($logs['poetry.client.response']['message'])->to->have->same->xml('messages/responses/response-status.xml');
        expect($logs['poetry.client.request']['message'])->to->contain('<request communication="synchrone" id="DGT/2017/00001/3/0/TRA" type="newPost">');
        expect($logs['poetry.client.request']['username'])->to->equal('username');
        expect($logs['poetry.client.request']['password'])->to->equal('p******d');
        expect($logs['poetry.response.parse']['message'])->to->have->same->xml('messages/responses/response-status.xml');
    }

    /**
     * Test exception.
     */
    public function testException()
    {
        $response = $this->getFixture('messages/responses/response-status.xml');
        $request = new CreateRequest(new Identifier(), new Settings());
        $mock = $this->getSoapClientMock();
        $mock->shouldReceive('requestService')->andReturn($response);

        $logger = new TestLogger();
        $poetry = new Poetry([
            'service.username' => 'username',
            'service.password' => 'password',
            'soap_client' => $mock,
            'logger' => $logger,
            'exceptions' => false,
        ]);

        $poetry->getClient()->send($request);
        $logs = $logger->getLogs()[LogLevel::ERROR];
        expect($logs['poetry.exception']['message'])
            ->contain('identifier.code: This value should not be blank.')
            ->contain('identifier.year: This value should not be blank.')
            ->contain('identifier.version: This value should not be blank.')
            ->contain('identifier.part: This value should not be blank.');
    }
}
