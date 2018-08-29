<?php

namespace EC\Poetry\Tests\Messages\Requests;

use EC\Poetry\Messages\Components\Contact;
use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Requests\CreateTranslationRequest;
use EC\Poetry\Messages\Requests\CreateReviewRequest;
use EC\Poetry\Poetry;
use EC\Poetry\Services\Settings;
use EC\Poetry\Tests\AbstractTest;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CreateReviewRequestTest
 *
 * @package EC\Poetry\Tests\Messages\Requests
 */
class CreateReviewRequestTest extends AbstractTest
{
    /**
     * Test default product.
     */
    public function testProductDefault()
    {
        $identifier = new Identifier();
        $identifier->setCode('STSI')
            ->setYear(2017)
            ->setNumber('40017')
            ->setVersion('0')
            ->setPart('11');

        new CreateReviewRequest($identifier, new Settings());
        expect($identifier->getProduct())->to->equal('REV');
    }

    /**
     * Test custom product.
     */
    public function testProductCustom()
    {
        $identifier = new Identifier();
        $identifier->setCode('STSI')
            ->setYear(2017)
            ->setNumber('40017')
            ->setVersion('0')
            ->setPart('11')
            ->setProduct('ABC');

        new CreateReviewRequest($identifier, new Settings());
        expect($identifier->getProduct())->to->equal('ABC');
    }

    /**
     * Test rendering.
     */
    public function testRender()
    {
        /** @var \EC\Poetry\Services\Renderer $renderer */
        $renderer = $this->getContainer()->get('renderer');

        $identifier = new Identifier();
        $identifier->setCode('STSI')
          ->setYear(2017)
          ->setNumber('40017')
          ->setVersion('0')
          ->setPart('11');

        $message = new CreateReviewRequest($identifier, new Settings());

        $message->withDetails()
            ->setClientId("Job ID 3999")
            ->setTitle("NE-CMS: Erasmus+ - Erasmus Mundus Joint Master Degrees")
            ->setAuthor('IE/CE/EAC')
            ->setResponsible('EAC')
            ->setRequester('IE/CE/EAC/C/4')
            ->setApplicationId('FPFIS')
            ->setDelay('12/09/2017')
            ->setReferenceFilesRemark('https://ec.europa.eu/programmes/erasmus-plus/opportunities-for-individuals/staff-teaching/erasmus-mundus_en')
            ->setProcedure('NEANT')
            ->setDestination('PUBLIC')
            ->setType('INTER')
            ->setWorkflowCode('STS');

        $message->withContact()->setType('auteur')->setNickname('john');
        $message->withContact()->setType('secretaire')->setNickname('john');
        $message->withContact()->setType('contact')->setNickname('john');
        $message->withContact()->setType('responsable')->setNickname('mark');

        $message->withReturnAddress()
            ->setAction('UPDATE')
            ->setType('webService')
            ->setUser('MY-TEST-USER')
            ->setPassword('MY-TEST-PASSWORD')
            ->setAddress('https://example.com/callback/wsdl/PoetryIntegration.wsdl')
            ->setPath('TestReturnPath');

        $message->withSource()
            ->setFormat('HTML')
            ->setName('content.html')
            ->setFile('BASE64ENCODEDFILECONTENT')
            ->setLegiswriteFormat('Yes')
            ->withSourceLanguage()
                ->setCode('EN')
                ->setPages(1);

        $message->withTarget()
            ->setAction('INSERT')
            ->setFormat('HTML')
            ->setLanguage('EN')
            ->setDelay('12/09/2017')
            ->setDelayFormat('DD/MM/YYYY');

        $output = $renderer->render($message);
        $violations = $this->getContainer()->getValidator()->validate($message);
        expect($this->getViolations($violations))->to->be->empty();
        expect($output)->to->have->same->xml('messages/requests/create-review-request.xml');
    }

    /**
     * @param array $array
     * @param array $expected
     *
     * @dataProvider withArrayProvider
     */
    public function testWithArray(array $array, array $expected)
    {
        $poetry = new Poetry([
            'identifier.code' => 'STSI',
            'identifier.year' => '2017',
            'identifier.number' => '40017',
            'identifier.version' => '0',
            'identifier.part' => '11',
            'notification.username' => 'MY-TEST-USER',
            'notification.password' => 'MY-TEST-PASSWORD',
            'client.wsdl' => 'https://example.com/callback/wsdl/PoetryIntegration.wsdl',
        ]);
        $component = $poetry->get('request.create_review_request');
        $component->withArray($array);

        foreach ($expected as $getComponent => $properties) {
            if ($this->isComponentCollection($properties)) {
                foreach ($properties as $i => $property) {
                    $this->assertProperties($component->$getComponent()[$i], $property);
                }
            } else {
                $this->assertProperties($component->$getComponent(), $properties);
            }
        }

        $violations = $this->getContainer()->getValidator()->validate($component);
        expect($this->getViolations($violations))->to->be->empty();
    }

    /**
     * @return mixed
     */
    public function withArrayProvider()
    {
        return Yaml::parse($this->getFixture('arrays/create-review-request.yml'));
    }
}
