<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Poetry;
use Peridot\Leo\Leo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractTest
 *
 * @package EC\Poetry\Tests
 */
abstract class AbstractTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $assertion = Leo::assertion();
        $unit = $this;
        $assertion->addMethod('xml', function ($fixture) use ($unit) {
            $actual = $this->getActual();
            $expected = $unit->getFixture($fixture);

            $doc1 = new \DOMDocument();
            $doc1->loadXML($actual);

            $doc2 = new \DOMDocument();
            $doc2->loadXML($expected);

            $element1 = $doc1->getElementsByTagName('POETRY')->item(0);
            $element2 = $doc2->getElementsByTagName('POETRY')->item(0);

            $unit->assertXmlStringEqualsXmlString($expected, $actual);
            $unit->assertEqualXMLStructure($element1, $element2);
        });
    }

    /**
     * @return \EC\Poetry\Poetry
     */
    public function getContainer()
    {
        return new Poetry();
    }

    /**
     * @return \EC\Poetry\Messages\Components\Identifier
     */
    public function getValidIdentifier()
    {
        $identifier = new Identifier();
        $identifier->setCode('DGT')
          ->setYear(2017)
          ->setNumber('00001')
          ->setVersion('3')
          ->setPart('0')
          ->setProduct('TRA');

        return $identifier;
    }

    /**
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $violations
     *
     * @return array
     */
    public function getViolations(ConstraintViolationListInterface $violations)
    {
        $collection = [];
        foreach ($violations as $violation) {
            $collection[$violation->getPropertyPath() ? $violation->getPropertyPath() : 'object'] = $violation->getMessage();
        }

        return $collection;
    }

    /**
     * @return \Mockery\MockInterface
     */
    public function getSoapClientMock()
    {
        return \Mockery::mock(\SoapClient::class);
    }

    /**
     * @param string $name
     *
     * @return bool|string
     */
    public function getFixture($name)
    {
        return file_get_contents(__DIR__.'/fixtures/'.$name);
    }

    /**
     * @param $properties
     * @return bool
     */
    protected function isComponentCollection($properties)
    {
        return is_int(key($properties));
    }

    /**
     * Assert property hash.
     *
     * @param $component
     * @param $properties
     */
    protected function assertProperties($component, $properties)
    {
        foreach ($properties as $getProperty => $value) {
            expect($component->$getProperty())->to->equal($value);
        }
    }
}
