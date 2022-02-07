<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Requests\CreateTranslationRequest;
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
        $message = $poetry->get('request.create_translation_request');
        $this->assertInstanceOf(CreateTranslationRequest::class, $message);

        /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violations */
        $violations = $poetry->get('validator')->validate($message);
        $this->assertNotEquals(0, $violations->count());

        $poetry = new Poetry([
            'identifier.code' => 'DGT',
            'identifier.year' => '2017',
            'identifier.number' => '0001',
            'identifier.version' => '01',
            'identifier.part' => '00',
            'identifier.product' => 'ABC',
        ]);
        $message = $poetry->get('request.create_translation_request');
        $violations = $poetry->get('validator')->validate($message);
        $this->assertEquals(0, $violations->count());
    }

    /**
     * Test container.
     */
    public function testContainer()
    {
        $poetry = new Poetry();

        $service = $poetry->get('renderer');
        $this->assertInstanceOf(Renderer::class, $service);

        $service = $poetry->get('renderer.engine');
        $this->assertInstanceOf(Engine::class, $service);

        $service = $poetry->get('validator');
        $this->assertInstanceOf(RecursiveValidator::class, $service);
    }
}
