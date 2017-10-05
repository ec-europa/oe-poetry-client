<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Events\Notifications\StatusUpdatedEvent;
use EC\Poetry\Messages\Notifications\StatusUpdated;
use EC\Poetry\Poetry;
use EC\Poetry\Events\NotificationEventInterface;
use EC\Poetry\Messages\Notifications\TranslationReceived;
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
        expect($server)->is->an->instanceof(\SoapServer::class);
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
            ]);
            $poetry->getEventDispatcher()->addListener(StatusUpdatedEvent::NAME, function (StatusUpdatedEvent $event) {
                expect($event->hasMessage())->be->true();
                expect($event->getMessage())->to->be->instanceof(StatusUpdated::class);
            });
            $poetry->getServer()->handle();
        };

        $this->setupServer('/notification', $callback);
        $message = $this->getFixture('messages/notifications/status-updated.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
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
