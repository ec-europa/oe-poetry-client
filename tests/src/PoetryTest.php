<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Poetry;
use League\Plates\Engine;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class PoetryTest
 *
 * @package EC\Poetry\Tests
 */
class PoetryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test container.
     */
    public function testContainer()
    {
        $poetry = new Poetry();

        $service = $poetry->get('renderer');
        expect($service)->to->be->instanceof(Engine::class);

        $service = $poetry->get('validator');
        expect($service)->to->be->instanceof(RecursiveValidator::class);


        /** @var \EC\Poetry\Server $server */
        $server = $poetry->get('server');
        $callback = $server->getCallback();
        expect($callback)->is->null();

        $value = 'callback';
        $poetry = new Poetry([
            'server.callback' => function () use ($value) {
                return "I'm the {$value}";
            },
        ]);

        /** @var \EC\Poetry\Server $server */
        $server = $poetry->get('server');
        $callback = $server->getCallback();
        expect($callback)->is->equal("I'm the callback");
    }
}
