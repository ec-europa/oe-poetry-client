<?php

namespace EC\Poetry\Tests\Services;

use EC\Poetry\Events\NotificationHandler\ReceivedNotificationEvent;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractHttpMockTest;
use EC\Poetry\Tests\Logger\TestLogger;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoggerSubscriberTest
 *
 * @package EC\Poetry\Tests\Services
 */
class LoggerSubscriberTest extends AbstractHttpMockTest
{
    /**
     * Test client logging.
     */
    public function testClientLogging()
    {
        $response = $this->getFixture('messages/responses/response-status.xml');
        $request = new CreateTranslationRequest($this->getValidIdentifier(), new Settings());
        $mock = $this->getSoapClientMock();
        $mock->shouldReceive('requestService')->andReturn($response);

        $logger = new TestLogger();
        $poetry = new Poetry([
            'service.username' => 'username',
            'service.password' => 'password',
            'soap_client' => $mock,
            'logger' => $logger,
            'log_level' => LogLevel::INFO,
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
        $request = new CreateTranslationRequest(new Identifier(), new Settings());
        $mock = $this->getSoapClientMock();
        $mock->shouldReceive('requestService')->andReturn($response);

        $logger = new TestLogger();
        $poetry = new Poetry([
            'service.username' => 'username',
            'service.password' => 'password',
            'soap_client' => $mock,
            'logger' => $logger,
            'exceptions' => false,
            'log_level' => LogLevel::INFO,
        ]);

        $poetry->getClient()->send($request);
        $logs = $logger->getLogs()[LogLevel::ERROR];
        expect($logs['poetry.exception']['message'])
            ->contain('identifier.code: This value should not be blank.')
            ->contain('identifier.year: This value should not be blank.')
            ->contain('identifier.version: This value should not be blank.')
            ->contain('identifier.part: This value should not be blank.');
    }

    /**
     * Test function callback.
     */
    public function testNotificationHandler()
    {
        $callback = function (Response $response) {
            $logger = new TestLogger();
            $poetry = new Poetry([
                'notification.username' => 'username',
                'notification.password' => 'password',
                'logger' => $logger,
                'log_level' => LogLevel::INFO,
            ]);
            $poetry->getServer()->handle();

            $logs = $logger->getLogs()[LogLevel::INFO];
            expect($logs)->not->empty();
            expect($logs[ReceivedNotificationEvent::NAME])->not->empty();
        };

        $this->setupServer('/notification', $callback);
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
    }

    /**
     * Test log levels.
     */
    public function testLogLevel()
    {
        $callback = function (Response $response) {
            $logger = new TestLogger();
            $poetry = new Poetry([
                'notification.username' => 'username',
                'notification.password' => 'password',
                'logger' => $logger,
                'log_level' => LogLevel::ERROR,
            ]);
            $poetry->getServer()->handle();

            expect($logger->getLogs()[LogLevel::INFO])->empty();
            expect($logger->getLogs()[LogLevel::ERROR])->empty();
        };

        $this->setupServer('/notification', $callback);
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
    }
}
