<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Poetry;
use EC\Poetry\Server;
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
        /** @var \SoapServer $soapServer */
        $soapServer = $this->getContainer()->get('soap.server');
        $functions = $soapServer->getFunctions();
        expect($functions)->to->equal(['OEPoetryCallback']);

        /** @var \EC\Poetry\Server $server */
        $server = $this->getContainer()->getServer();
        expect($server)->is->an->instanceof(\SoapServer::class);
    }

    /**
     * Test function callback.
     */
    public function testFunctionCallback()
    {
        $this->setupNotificationServer('/notification');
        $message = $this->getFixture('messages/response-status-1.xml');
        $this->notify('/notification', $message);
    }

    /**
     * Setup notification endpoint.
     */
    protected function setupNotificationServer($endpoint)
    {
        // @codingStandardsIgnoreStart
        $this->http->mock
          ->when()
              ->methodIs('POST')
              ->pathIs($endpoint)
          ->then()
          ->callback(
            function (Response $response) {
                (new Poetry())->getServer()->handle();
            }
          )
          ->end();
        $this->http->setUp();
        // @codingStandardsIgnoreEnd
    }

    /**
     * Notify SOAP endpoint.
     *
     * @param string $endpoint
     *    Endpoint URL.
     * @param $message
     *    XML message
     *
     * @return mixed
     *    SOAP call response.
     */
    protected function notify($endpoint, $message)
    {
        $poetry = new Poetry();
        $rendered = $poetry->getRenderEngine()->render('wsdl', [
            'callback' => 'http://localhost:8082'.$endpoint,
        ]);
        $wsdl = 'data://text/plain;base64,'.base64_encode($rendered);
        $client = new \SoapClient($wsdl, ['cache_wsdl' => WSDL_CACHE_NONE]);

        return $client->__soapCall('OEPoetryCallback', ['username', 'password', $message]);
    }
}
