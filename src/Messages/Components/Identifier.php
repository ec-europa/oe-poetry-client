<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Class Identifier
 *
 * @package EC\Poetry\Messages\Components
 */
class Identifier extends AbstractComponent
{
    private $code;
    private $year;
    private $number;
    private $sequence;
    private $version;
    private $part;
    private $product;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::identifier';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('code', [
            new Assert\NotBlank(),
            new Assert\Type('alpha'),
        ]);
        $metadata->addPropertyConstraints('year', [
            new Assert\NotBlank(),
            new Assert\Type('scalar'),
            new Assert\GreaterThan(2000),
        ]);
        $metadata->addPropertyConstraint('number', new Assert\Type('scalar'));
        $metadata->addPropertyConstraint('sequence', new Assert\Type('string'));
        $metadata->addPropertyConstraints('version', [
            new Assert\NotBlank(),
            new Assert\Type('scalar'),
        ]);
        $metadata->addPropertyConstraints('part', [
            new Assert\NotBlank(),
            new Assert\Type('scalar'),
        ]);
        $metadata->addPropertyConstraints('product', [
            new Assert\NotBlank(),
            new Assert\Type('alpha'),
        ]);
    }

    /**
     * @return string
     */
    public function getFormattedIdentifier()
    {
        return implode('/', [
            $this->getCode(),
            $this->getYear(),
            $this->getNumber() ? $this->getNumber() : $this->getSequence(),
            $this->getVersion(),
            $this->getPart(),
            $this->getProduct(),
        ]);
    }

    /**
     * Get Code property.
     *
     * @return mixed
     *   Property value.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Code property.
     *
     * @param mixed $code
     *   Property value.
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Year property.
     *
     * @return mixed
     *   Property value.
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set Year property.
     *
     * @param mixed $year
     *   Property value.
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get Version property.
     *
     * @return mixed
     *   Property value.
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set Version property.
     *
     * @param mixed $version
     *   Property value.
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get Number property.
     *
     * @return mixed
     *   Property value.
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set Number property.
     *
     * @param mixed $number
     *   Property value.
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param mixed $sequence
     * @return Identifier
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get Part property.
     *
     * @return mixed
     *   Property value.
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set Part property.
     *
     * @param mixed $part
     *   Property value.
     *
     * @return $this
     */
    public function setPart($part)
    {
        $this->part = $part;

        return $this;
    }

    /**
     * Get Product property.
     *
     * @return mixed
     *   Property value.
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set Product property.
     *
     * @param mixed $product
     *   Property value.
     *
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Returns which validation groups should be used for a certain state
     * of the object.
     *
     * @return array An array of validation groups
     */
    public function getGroupSequence()
    {
        return [
          [
            'Identifier',
            empty($this->getNumber()) ? 'sequence' : 'number',
          ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setCode($parser->getContent('demandeId/codeDemandeur'))
            ->setYear($parser->getContent('demandeId/annee'))
            ->setNumber($parser->getContent('demandeId/numero'))
            ->setVersion($parser->getContent('demandeId/version'))
            ->setPart($parser->getContent('demandeId/partie'))
            ->setProduct($parser->getContent('demandeId/produit'));

        return $this;
    }
}
