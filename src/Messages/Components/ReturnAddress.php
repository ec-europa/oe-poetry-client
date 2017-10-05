<?php

namespace EC\Poetry\Messages\Components;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ReturnAddress
 *
 * @package EC\Poetry\Messages\Components
 */
class ReturnAddress extends AbstractComponent
{
    private $type;
    private $action;
    private $user;
    private $password;
    private $address;
    private $path;
    private $remark;

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'components::return-address';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('type', [
            new Assert\Choice(['webService', 'email']),
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('action', new Assert\Choice(['INSERT', 'UPDATE']));
        $metadata->addPropertyConstraints('address', [
            new Assert\Type('string'),
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('password', new Assert\Expression([
            'expression' => 'this.getType() == "webService"',
            'message' => 'The return type you selected can\'t have a password.',
        ]));
        $metadata->addPropertyConstraint('path', new Assert\Expression([
            'expression' => 'this.getType() == "webService"',
            'message' => 'The return type you selected can\'t have a path.',
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = [
            'type' => $this->getType(),
            'action' => $this->getAction(),
        ];

        return array_filter($attributes);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return ReturnAddress
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     * @return ReturnAddress
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return ReturnAddress
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return ReturnAddress
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return ReturnAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return ReturnAddress
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     * @return ReturnAddress
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseXml($xml)
    {
        $parser = $this->getParser();
        $parser->addXmlContent($xml);

        $this->setType($parser->getAttribute('retour', 'type'))
            ->setAction($parser->getAttribute('retour', 'action'))
            ->setUser($parser->getContent('retour/retourUser'))
            ->setPassword($parser->getContent('retour/retourPassword'))
            ->setAddress($parser->getContent('retour/retourAddress'))
            ->setPath($parser->getContent('retour/retourPath'))
            ->setRemark($parser->getContent('retour/retourRemark'));

        return $this;
    }
}
