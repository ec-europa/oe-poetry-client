<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Requests\AbstractRequest;
use EC\Poetry\Messages\Requests\CreateRequest;
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
        $message = $poetry->get('request.create_request');
        expect($message)->to->be->instanceof(CreateRequest::class);

        /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violations */
        $violations = $poetry->get('validator')->validate($message);
        expect($violations->count())->not->to->be->empty();

        $poetry = new Poetry([
            'type' => AbstractRequest::REQUEST_STATUS,
            'identifier.code' => 'DGT',
            'identifier.year' => '2017',
            'identifier.number' => '0001',
            'identifier.version' => '01',
            'identifier.part' => '00',
            'identifier.product' => 'ABC',
        ]);
        $message = $poetry->get('request.create_request');
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
}
