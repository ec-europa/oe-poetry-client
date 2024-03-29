<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractTest;

/**
 * Class CreateTranslationRequestTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class CreateTranslationRequestTest extends AbstractTest
{
    /**
     * Test default product.
     */
    public function testProductDefault()
    {
        $identifier = new Identifier();
        $identifier->setCode('DGT')
            ->setYear(2017)
            ->setNumber('00001')
            ->setVersion('01')
            ->setPart('00');

        new CreateTranslationRequest($identifier, new Settings());
        $this->assertEquals('TRA', $identifier->getProduct());
    }

    /**
     * Test custom product.
     */
    public function testProductCustom()
    {
        $identifier = new Identifier();
        $identifier->setCode('DGT')
            ->setYear(2017)
            ->setNumber('00001')
            ->setVersion('01')
            ->setPart('00')
            ->setProduct('ABC');

        new CreateTranslationRequest($identifier, new Settings());
        $this->assertEquals('ABC', $identifier->getProduct());
    }

    /**
     * Test object factories.
     */
    public function testFactories()
    {
        $identifier = $this->getValidIdentifier();

        $request = new CreateTranslationRequest($identifier, new Settings());

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
        $this->assertEmpty($this->getViolations($violations));
        $this->assertInstanceOf(Contact::class, $request->getContacts()[0]);
        $this->assertInstanceOf(Contact::class, $request->getContacts()[1]);
        $this->assertEquals('IMG', $request->getDetails()->getType());
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

        $message = new CreateTranslationRequest($identifier, new Settings());

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
            ->setRequestDate('14/09/2017')
            ->setDelay('14/09/2017');

        $output = $renderer->render($message);
        $this->assertXmlFromFixture('messages/requests/create-translation-request.xml', $output);
    }
}
