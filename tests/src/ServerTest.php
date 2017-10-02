<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Poetry;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ServerTest
 *
 * @package EC\Poetry
 */
class ServerTest extends AbstractTest
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
        /** @var \EC\Poetry\Server $server */
        $server = $this->getContainer()->getServer();
        expect($server)->is->an->instanceof(\SoapServer::class);
    }

    /**
     * Test function callback.
     */
    public function testFunctionCallback()
    {
        $this->setupServer('/notification', 'username', 'password');

        $message = $this->getFixture('messages/responses/response-status.xml');
        $this->notifyServer('/notification', 'username', 'password', $message);
    }

    /**
     * Setup notification endpoint.
     */
    protected function setupServer($endpoint, $username, $password)
    {
        // @codingStandardsIgnoreStart
        $this->http->mock
          ->when()
              ->methodIs('POST')
              ->pathIs($endpoint)
          ->then()
          ->callback(
            function (Response $response) use ($username, $password) {
                $poetry = new Poetry([
                  'notification.username' => $username,
                  'notification.password' => $password,
                ]);
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
