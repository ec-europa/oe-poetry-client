<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Events\NotificationEventInterface;
use EC\Poetry\Events\Notifications\TranslationReceivedEvent;
use EC\Poetry\Messages\Notifications\TranslationReceived;
use EC\Poetry\Poetry;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotificationHandlerTest
 *
 * @package EC\Poetry
 */
class NotificationHandlerTest extends AbstractTest
{
    use HttpMockTrait;

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        static::setUpHttpMockBeforeClass('8082', 'localhost');
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        static::tearDownHttpMockAfterClass();
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->setUpHttpMock();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->tearDownHttpMock();
    }

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
        $this->setupServer('/notification', [
            'notification.username' => 'username',
            'notification.password' => 'password',
              'test.event' => 'poetry.notification.translation_received',
              'test.listener' => [NotificationHandlerTest::class, 'listener'],
        ]);

        $message = $this->getFixture('messages/notifications/request-accepted.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
    }

    /**
     * @param \EC\Poetry\Events\NotificationEventInterface $event
     */
    public static function listener(NotificationEventInterface $event)
    {
        expect($event->hasMessage())->be->true();
        expect($event->getMessage())->to->be->instanceof(TranslationReceived::class);
    }

    /**
     * Setup notification endpoint.
     */
    protected function setupServer($endpoint, $parameters)
    {
        // @codingStandardsIgnoreStart
        $this->http->mock
          ->when()
              ->methodIs('POST')
              ->pathIs($endpoint)
          ->then()
          ->callback(
            function (Response $response) use ($parameters) {
                $poetry = new Poetry($parameters);
                $poetry->getEventDispatcher()->addListener($parameters['test.event'], $parameters['test.listener']);
                $poetry->getServer()->handle();
            }
          )
          ->end();
        $this->http->setUp();
        // @codingStandardsIgnoreEnd
    }

    /**
     * Notify SOAP endpoint.
     *
     * @param $endpoint
     * @param $username
     * @param $password
     * @param $message
     *
     * @return mixed
     */
    protected function notifyServer($endpoint, $username, $password, $message)
    {
        $rendered = $this->getContainer()->getRenderEngine()->render('wsdl', [
            'callback' => 'http://localhost:8082'.$endpoint,
        ]);
        $wsdl = 'data://text/plain;base64,'.base64_encode($rendered);
        $client = new \SoapClient($wsdl, ['cache_wsdl' => WSDL_CACHE_NONE]);

        return $client->__soapCall('handle', [$username, $password, $message]);
    }
}
