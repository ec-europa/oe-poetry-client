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
            $messages['messages'][] = "Request method should be set to POST.";
        }
        if (!isset($_SERVER['HTTP_SOAPACTION'])) {
            $messages['messages'][] = "SOAP action header should be defined.";
        }


        if (!empty($messages)) {
            $messages['server'] = $_SERVER;
            $messages['raw_post'] = file_get_contents('php://input');

            $this->dispatchExceptionEvent(new ServerException(print_r($messages, true)), true);
        }
    }
}
