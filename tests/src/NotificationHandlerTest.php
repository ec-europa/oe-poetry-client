<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Messages\Notifications\StatusUpdated;
use EC\Poetry\Poetry;
use EC\Poetry\Events\NotificationEventInterface;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Server;
use GuzzleHttp\Psr7\Request;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotificationHandlerTest
 *
 * @package EC\Poetry
 */
class NotificationHandlerTest extends AbstractHttpMockTest
{
    /**
     * Test server.
     */
    public function testServer()
    {
        $server = $this->getContainer()->getServer();
        $this->assertInstanceOf(Server::class, $server);
    }

    /**
     * Test function callback.
     */
    public function testFunctionCallback()
    {
        $callback = function (Response $response) {
            $poetry = new Poetry([
                'notification.username' => 'username',
                'notification.password' => 'password',
                'log_level' => LogLevel::INFO,
            ]);
            $poetry->getEventDispatcher()->addListener(StatusUpdatedEvent::NAME, function (StatusUpdatedEvent $event) {
                self::assertTrue($event->hasMessage());
                self::assertInstanceOf(StatusUpdated::class, $event->getMessage());
            });
            $poetry->getServer()->handle();
        };

        $this->setupServer('/notification', $callback);

        // Test a correct notification.
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $response = $this->notifyServer('/notification', 'username', 'password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        $this->assertEquals('1069698', $status->getMessageId());
        date_default_timezone_set('Europe/Brussels');
        $this->assertEquals(date('d/m/Y'), $status->getStatuses()[0]->getDate());
        // TODO: Fix timezone issue on CI.
        //$this->assertEquals(date('H:i:s'), $status->getStatuses()[0]->getTime());
        $this->assertEquals('OK', $status->getStatuses()[0]->getMessage());
        $this->assertEquals('0', $status->getStatuses()[0]->getCode());

        // Test an incorrect notification .
        $message = $this->getFixture('messages/notifications/status-updated-nok.xml');
        $response = $this->notifyServer('/notification', 'username', 'password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        $this->assertEquals('identifier.year: This value should be greater than 2000.', $status->getStatuses()[0]->getMessage());
        $this->assertEquals('-1', $status->getStatuses()[0]->getCode());

        // Test an incorrect authentication.
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $response = $this->notifyServer('/notification', 'wrong-username', 'wrong-password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        $this->assertEquals('Poetry service cannot authenticate on notification callback: username or password not valid.', $status->getStatuses()[0]->getMessage());
        $this->assertEquals('-1', $status->getStatuses()[0]->getCode());
    }

    /**
     * Test bad request.
     */
    public function testBadRequest()
    {
        $file = $this->logFile;
        $callback = function (Response $response) use ($file) {
            @unlink($file);
            $formatter = new JsonFormatter();
            $stream = new StreamHandler($file, Logger::INFO);
            $stream->setFormatter($formatter);
            $logger = new Logger('Test Logger');
            $logger->pushHandler($stream);

            $poetry = new Poetry([
                'notification.username' => 'username',
                'notification.password' => 'password',
                'exceptions' => false,
                'logger' => $logger,
                'log_level' => LogLevel::INFO,
            ]);
            $poetry->getServer()->handle();
        };

        $this->setupServer('/bad-request', $callback);
        $request = new Request('HEAD', 'http://httpbin.org/head', ['x-test' => 'value'], 'test body');
        $this->http->client->sendRequest($request);

        $logs = $this->getLogs();
        $this->assertStringContainsString('SOAP action header should be defined.', $logs[0]->context->message);
        $this->assertStringContainsString('[raw_post] => test body', $logs[0]->context->message);
        $this->assertStringContainsString('[HTTP_X_TEST] => value', $logs[0]->context->message);
        $this->assertStringContainsString('[REQUEST_METHOD] => POST', $logs[0]->context->message);
    }

    /**
     * @param \EC\Poetry\Events\NotificationEventInterface $event
     */
    public static function onTranslationReceived(NotificationEventInterface $event)
    {
        self::assertTrue($event->hasMessage());
        self::assertInstanceOf(TranslationReceived::class, $event->getMessage());
    }
}
