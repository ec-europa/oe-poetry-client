<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateRequest;
use EC\Poetry\Messages\Requests\RequestNewNumber;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractTest;

/**
 * Class RequestNewNumberTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class RequestNewNumberTest extends AbstractTest
{
    /**
     * Test rendering.
     */
    public function testRender()
    {
        /** @var \EC\Poetry\Services\Renderer $renderer */
        $renderer = $this->getContainer()->get('renderer');

        $identifier = new Identifier();
        $identifier->setCode('DGT')
          ->setYear('2017')
          ->setSequence('MY_SEQUENCE')
          ->setVersion('01')
          ->setPart('00');

        $message = new RequestNewNumber($identifier, new Settings());

        $output = $renderer->render($message);
        expect($output)->to->have->same->xml('messages/requests/request-new-number.xml');
    }
}
