<?php

namespace EC\Poetry;

use EC\Poetry\Exceptions\ServerException;
use EC\Poetry\Traits\DispatchExceptionEventTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Server
 *
 * @package EC\Poetry\Services
 */
class Server
{
    use DispatchExceptionEventTrait;

    /**
     * @var \SoapServer
     */
    private $soapServer;

    /**
     * Server constructor.
     *
     * @param \SoapServer                                        $soapServer
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     */
    public function __construct(\SoapServer $soapServer, EventDispatcher $eventDispatcher)
    {
        $this->soapServer = $soapServer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $this->ensureValidRequest();
        $this->soapServer->handle();
    }

    /**
     * Check whereas current HTTP request is a valid SOAP request.
     */
    protected function ensureValidRequest()
    {
        $messages = [];
        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $messages[] = "Request method should be set to POST.";
        }
        if (!isset($_SERVER['HTTP_SOAPACTION'])) {
            $messages[] = "SOAP action header should be defined.";
        }
        $headers = getallheaders();
        if (!isset($headers['Content-Type']) || (strstr(strtolower($headers['Content-Type']), 'application/soap+xml') !== false)) {
            $messages[] = "Content-Type should contain 'application/soap+xml'.";
        }

        if (!empty($messages)) {
            $this->dispatchExceptionEvent(new ServerException(implode(' ', $messages)));
        }
    }
}
