<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Poetry;
use EC\Poetry\Server;

/**
 * Class ServerTest
 *
 * @package EC\Poetry
 */
class ServerTest extends AbstractTest
{
    /**
     * Test server.
     */
    public function testServer()
    {
        /** @var \SoapServer $soapServer */
        $soapServer = $this->getContainer()->get('soap.server');
        $functions = $soapServer->getFunctions();
        expect($functions)->to->equal(['EC\Poetry\callback']);

        /** @var \EC\Poetry\Server $server */
        $server = $this->getContainer()->get('server');
        expect($server)->is->an->instanceof(Server::class);
    }

    /**
     * Test function callback.
     */
    public function testFunctionCallback()
    {
        $value = 'callback';
        $poetry = new Poetry([
            'server.callback' => function ($user, $password, $message) use ($value) {
                return "I'm the {$value} called with ".implode(' ', [$user, $password, $message]);
            },
        ]);

        $expected = "I'm the callback called with john smith message";
        $response = \EC\Poetry\callback('john', 'smith', 'message');
        expect($response)->to->equal($expected);
        expect($poetry->getServer()->getResponse())->to->equal($expected);
    }
}
