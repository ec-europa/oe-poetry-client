<?php

namespace EC\Poetry;

use EC\Poetry\Services\Parsers\ParserInterface;

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
     * @var \EC\Poetry\Services\Parsers\ParserInterface[]
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
     * Server constructor.
     *
     * @param \SoapServer                                   $soapServer
     * @param \EC\Poetry\Services\Parsers\ParserInterface[] $parsers
     */
    public function __construct(\SoapServer $soapServer, array $parsers)
    {
        $this->soapServer = $soapServer;
        $this->parsers = $parsers;
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
