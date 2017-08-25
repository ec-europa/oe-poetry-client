<?php

namespace EC\Poetry;

use EC\Poetry\Parsers\ParserInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Server
 *
 * @package EC\Poetry
 */
class Server
{
    /**
     * Parser services.
     *
     * @var \EC\Poetry\Parsers\ParserInterface[]
     */
    protected $parsers;

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
     * @param \SoapServer                          $soapServer
     * @param \EC\Poetry\Parsers\ParserInterface[] $parsers
     * @param \Psr\Log\LoggerInterface             $logger
     */
    public function __construct(\SoapServer $soapServer, array $parsers, LoggerInterface $logger)
    {
        $this->soapServer = $soapServer;
        $this->parsers = $parsers;
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
