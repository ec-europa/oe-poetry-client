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
        expect($this->getViolations($violations))->to->be->empty();
        expect($request->getTargets()[0])->to->be->instanceof(Target::class);
        expect($request->getTargets()[0]->getLanguage())->be->equal('FR');
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
            ->setLanguage('FR')
            ->setFormat('HTML')
            ->setDelay('14/09/2017')
            ->withReturnAddress()
            ->setType('webService')
            ->setUser('MY-TEST-USER')
            ->setAddress('Url');

        $output = $renderer->render($message);
        expect($output)->to->have->same->xml('messages/requests/add-languages-request.xml');
    }
}
