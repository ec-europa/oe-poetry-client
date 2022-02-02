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

        $this->assertArrayHasKey('poetry.client.request', $logs);
        $this->assertArrayHasKey('poetry.client.response', $logs);
        $this->assertArrayHasKey('poetry.response.parse', $logs);
        $this->assertXmlFromFixture('messages/responses/response-status.xml', $logs['poetry.client.response']['message']);
        $this->assertStringContainsString('<request communication="synchrone" id="DGT/2017/00001/3/0/TRA" type="newPost">', $logs['poetry.client.request']['message']);
        $this->assertEquals('username', $logs['poetry.client.request']['username']);
        $this->assertEquals('p******d', $logs['poetry.client.request']['password']);
        $this->assertXmlFromFixture('messages/responses/response-status.xml', $logs['poetry.response.parse']['message']);
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
        $this->assertStringContainsString('identifier.code: This value should not be blank.', $logs['poetry.exception']['message']);
        $this->assertStringContainsString('identifier.year: This value should not be blank.', $logs['poetry.exception']['message']);
        $this->assertStringContainsString('identifier.version: This value should not be blank.', $logs['poetry.exception']['message']);
        $this->assertStringContainsString('identifier.part: This value should not be blank.', $logs['poetry.exception']['message']);
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
            self::assertNotEmpty($logs);
            self::assertNotEmpty($logs[ReceivedNotificationEvent::NAME]);
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

            self::assertEmpty($logger->getLogs()[LogLevel::INFO]);
            self::assertEmpty($logger->getLogs()[LogLevel::ERROR]);
        };

        $this->setupServer('/notification', $callback);
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
    }
}
