<?php

namespace EC\Poetry\Tests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Request;
use EC\Poetry\Poetry;
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
     * @return \EC\Poetry\Poetry
     */
    protected function getContainer()
    {
        return new Poetry();
    }

    /**
     * @return \EC\Poetry\Messages\Components\Identifier
     */
    protected function getValidIdentifier()
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
    protected function getViolations(ConstraintViolationListInterface $violations)
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
    protected function getSoapClientMock()
    {
        return \Mockery::mock(\SoapClient::class);
    }

    /**
     * @param $name
     *
     * @return bool|string
     */
    protected function getFixture($name)
    {
        return file_get_contents(__DIR__.'/fixtures/'.$name);
    }
}
