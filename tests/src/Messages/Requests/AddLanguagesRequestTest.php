<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\Target;
use EC\Poetry\Messages\Requests\AddLanguagesRequest;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractTest;

/**
 * @package EC\Poetry\Tests\Messages\Requests
 */
class AddLanguagesRequestTest extends AbstractTest
{
    /**
     * Test object factories.
     */
    public function testFactories()
    {
        $identifier = $this->getValidIdentifier();

        $request = new AddLanguagesRequest($identifier, new Settings());

        $request->withTarget()
            ->setLanguage('FR')
            ->setFormat('HTML')
            ->setDelay('14/09/2017');

        $violations = $this->getContainer()->get('validator')->validate($request);
        $this->assertEmpty($this->getViolations($violations));
        $this->assertInstanceOf(Target::class, $request->getTargets()[0]);
        $this->assertEquals('FR', $request->getTargets()[0]->getLanguage());
    }

    /**
     * Test rendering.
     */
    public function testRender()
    {
        /** @var \EC\Poetry\Services\Renderer $renderer */
        $renderer = $this->getContainer()->get('renderer');

        $identifier = new Identifier();
        $identifier->setCode('DGT')
            ->setYear(2017)
            ->setNumber('00001')
            ->setVersion('01')
            ->setPart('00')
            ->setProduct('TRA');

        $message = new AddLanguagesRequest($identifier, new Settings());

        $message->withTarget()
            ->setAction('INSERT')
            ->setLanguage('FR')
            ->setFormat('HTML')
            ->setDelay('14/09/2017')
            ->withReturnAddress()
            ->setType('webService')
            ->setUser('MY-TEST-USER')
            ->setAddress('Url');

        $output = $renderer->render($message);
        $this->assertXmlFromFixture('messages/requests/add-languages-request.xml', $output);
    }
}
