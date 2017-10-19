<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Poetry;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractHttpMockTest
 *
 * @package EC\Poetry\Tests
 */
abstract class AbstractHttpMockTest extends AbstractTest
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
     * Setup notification endpoint.
     */
    protected function setupServer($endpoint, \Closure $callback, $method = 'POST')
    {
        // @codingStandardsIgnoreStart
        $this->http->mock
          ->when()
          ->methodIs($method)
          ->pathIs($endpoint)
          ->then()
          ->callback($callback)
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
