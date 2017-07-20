<?php

namespace EC\Poetry;

use EC\Poetry\Services\Parser;

/**
 * Class Server
 *
 * @package EC\Poetry
 */
class Server
{
    /**
     * Custom XML parser.
     *
     * @var \EC\Poetry\Services\Parser
     */
    protected $parser;

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
     * @param \SoapServer                $soapServer
     * @param \EC\Poetry\Services\Parser $parser
     */
    public function __construct(\SoapServer $soapServer, Parser $parser)
    {
        $this->soapServer = $soapServer;
        $this->parser = $parser;
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
