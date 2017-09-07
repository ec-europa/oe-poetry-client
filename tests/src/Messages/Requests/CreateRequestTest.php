<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
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
}
