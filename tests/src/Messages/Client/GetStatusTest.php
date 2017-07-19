<?php

namespace EC\Poetry\Tests\Messages\Client;

use EC\Poetry\Messages\RequestMessage;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Poetry;
use PHPUnit\Framework\TestCase;

/**
 * Class GetStatusTest
 *
 * @package EC\Poetry\Tests\Messages\Client
 */
class GetStatusTest extends TestCase
{
    /**
     * Test rendering.
     */
    public function testRender()
    {
        /** @var \EC\Poetry\Services\Renderer $renderer */
        $renderer = (new Poetry())->get('renderer');

        $identifier = new Identifier();
        $identifier->setCode('DGT')
          ->setYear(2017)
          ->setNumber('00001')
          ->setVersion('01')
          ->setPart('00')
          ->setProduct('TRA');
        $message = new RequestMessage($identifier);
        $message->setType(RequestMessage::REQUEST_STATUS);
        $output = $renderer->render($message);
        expect($output)
          ->to->not->be->empty()
          ->and->to->contain('DGT/2017/00001/01/00/TRA')
          ->and->to->contain('<codeDemandeur>DGT</codeDemandeur>')
          ->and->to->contain('<annee>2017</annee>')
          ->and->to->contain('<numero>00001</numero>')
          ->and->to->contain('<version>01</version>')
          ->and->to->contain('<partie>00</partie>')
          ->and->to->contain('<produit>TRA</produit>');
    }
}
