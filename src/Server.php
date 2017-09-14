<?php

namespace EC\Poetry;

use Psr\Log\LoggerInterface;

/**
 * Class Server
 *
 * @package EC\Poetry
 */
class Server
{
    /**
     * @var \SoapServer
     */
    protected $soapServer;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Server constructor.
     *
     * @param \SoapServer              $soapServer
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\SoapServer $soapServer, LoggerInterface $logger)
    {
        $this->soapServer = $soapServer;
        $this->logger = $logger;
    }

    /**
     * @param string $soapRequest
     */
    public function handle($soapRequest = null)
    {
        $this->soapServer->handle($soapRequest);
    }

    /**
     * Get Response property.
     *
     * @return mixed
     *   Property value.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set Response property.
     *
     * @param mixed $response
     *   Property value.
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
