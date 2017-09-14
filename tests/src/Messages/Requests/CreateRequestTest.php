<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Tests\AbstractTest;

/**
 * Class CreateRequestTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class CreateRequestTest extends AbstractTest
{
    /**
     * Test object factories.
     */
    public function testFactories()
    {
        $identifier = $this->getValidIdentifier();

        $request = new CreateRequest($identifier);

        $request->withContact()
            ->setType('Contact')
            ->setNickname('john')
            ->setAction('INSERT');

        $request->withContact()
            ->setType('Responsible')
            ->setNickname('Bob')
            ->setAction('INSERT')
            ->setEmail('me@example.com');

        $request->withDetails()
            ->setType('IMG')
            ->setApplicationId('1234')
            ->setDestination('INTERNE');

        $violations = $this->getContainer()->get('validator')->validate($request);
        expect($this->getViolations($violations))->to->be->empty();
        expect($request->getContacts()[0])->to->be->instanceof(Contact::class);
        expect($request->getContacts()[1])->to->be->instanceof(Contact::class);
        expect($request->getDetails()->getType())->be->equal('IMG');
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

        $message = new CreateRequest($identifier);

        $message->withDetails()
            ->setClientId("clientID")
            ->setApplicationId("applicationId")
            ->setAuthor("DIGIT")
            ->setRequester("DGT")
            ->setTitle("Title")
            ->setRemark("This is a remark")
            ->setType("PUB")
            ->setDestination("PUBLIC")
            ->setProcedure("NEANT")
            ->setRequestDate(date('d/m/Y'))
            ->setDelay(date('d/m/Y', time('+1 day')));

        $output = $renderer->render($message);
        expect($output)->to->have->same->xml('messages/create-request-1.xml');
    }
}
