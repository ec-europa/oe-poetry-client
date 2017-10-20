<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Notifications\StatusUpdated;
use EC\Poetry\Messages\Responses\Status;
use EC\Poetry\Poetry;
use EC\Poetry\Events\NotificationEventInterface;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Server;
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
        expect($server)->is->an->instanceof(Server::class);
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
                expect($event->hasMessage())->be->true();
                expect($event->getMessage())->to->be->instanceof(StatusUpdated::class);
            });
            $poetry->getServer()->handle();
        };

        $this->setupServer('/notification', $callback);

        // Test a correct notification.
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $response = $this->notifyServer('/notification', 'username', 'password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        expect($status->getMessageId())->to->be->equal('1069698');
        date_default_timezone_set('Europe/Brussels');
        expect($status->getStatuses()[0]->getDate())->to->be->equal(date('d/m/Y'));
        // TODO: Fix timezone issue on CI.
        //expect($status->getStatuses()[0]->getTime())->to->be->equal(date('H:i:s'));
        expect($status->getStatuses()[0]->getMessage())->to->be->equal('OK');
        expect($status->getStatuses()[0]->getCode())->to->be->equal('0');

        // Test an incorrect notification .
        $message = $this->getFixture('messages/notifications/status-updated-nok.xml');
        $response = $this->notifyServer('/notification', 'username', 'password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        expect($status->getStatuses()[0]->getMessage())->to->be->equal('identifier.year: This value should be greater than 2000.');
        expect($status->getStatuses()[0]->getCode())->to->be->equal('-1');

        // Test an incorrect authentication.
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $response = $this->notifyServer('/notification', 'wrong-username', 'wrong-password', $message);
        /** @var \EC\Poetry\Messages\Responses\Status $status */
        $status = $this->getContainer()->get('response.status')->fromXml($response);
        expect($status->getStatuses()[0]->getMessage())->to->be->equal('Poetry service cannot authenticate on notification callback: username or password not valid.');
        expect($status->getStatuses()[0]->getCode())->to->be->equal('-1');
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
        $this->http->client->post('http://localhost:8082/bad-request', ['x-test' => 'value'], 'test body')->send();

        $logs = $this->getLogs();
        expect($logs[0]->context->message)
            ->contain('SOAP action header should be defined.')
            ->and->contain('[raw_post] => test body')
            ->and->contain('[HTTP_X_TEST] => value')
            ->and->contain('[REQUEST_METHOD] => POST');
    }

    /**
     * @param \EC\Poetry\Events\NotificationEventInterface $event
     */
    public static function onTranslationReceived(NotificationEventInterface $event)
    {
        expect($event->hasMessage())->be->true();
        expect($event->getMessage())->to->be->instanceof(TranslationReceived::class);
    }
}
