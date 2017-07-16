<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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
        $metadata->addPropertyConstraints('number', [
            new Assert\NotBlank(),
            new Assert\Type('scalar'),
        ]);
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
        $parts = [
            $this->code,
            $this->year,
            $this->number,
            $this->version,
            $this->part,
            $this->product,
        ];

        return implode('/', $parts);
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
}
