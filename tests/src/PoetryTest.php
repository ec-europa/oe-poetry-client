<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Client\GetStatus;
use EC\Poetry\Poetry;
use EC\Poetry\Tests\AbstractTest as TestCase;
use EC\Poetry\Services\Renderer;
use League\Plates\Engine;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * Class PoetryTest
 *
 * @package EC\Poetry\Tests
 */
class PoetryTest extends TestCase
{
    /**
     * Test message container.
     */
    public function testMessageContainer()
    {
        $poetry = new Poetry();
        /** @var \EC\Poetry\Messages\Client\GetStatus $message */
        $message = $poetry->get('message.client.get_status');
        expect($message)->to->be->instanceof(GetStatus::class);

        /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violations */
        $violations = $poetry->get('validator')->validate($message);
        expect($violations->count())->not->to->be->empty();

        $poetry = new Poetry([
            'identifier' => [
                'code' => 'DGT',
                'year' => '2017',
                'number' => '0001',
                'version' => '01',
                'part' => '00',
                'product' => 'ABC',
            ],
        ]);
        $message = $poetry->get('message.client.get_status');
        $violations = $poetry->get('validator')->validate($message);
        expect($violations->count())->to->be->empty();
    }

    /**
     * Test container.
     */
    public function testContainer()
    {
        $poetry = new Poetry();

        $service = $poetry->get('renderer');
        expect($service)->to->be->instanceof(Renderer::class);

        $service = $poetry->get('renderer.engine');
        expect($service)->to->be->instanceof(Engine::class);

        $service = $poetry->get('validator');
        expect($service)->to->be->instanceof(RecursiveValidator::class);
    }

    /**
     * Test possibility to override service container parameters.
     */
    public function testParameterOverrides()
    {
        $poetry = new Poetry();

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
