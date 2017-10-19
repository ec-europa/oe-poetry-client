<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Traits\WithContactsTrait;
use EC\Poetry\Messages\Traits\WithDetailsTrait;
use EC\Poetry\Messages\Traits\WithReferenceDocumentsTrait;
use EC\Poetry\Messages\Traits\WithReturnAddressTrait;
use EC\Poetry\Messages\Traits\WithSourceTrait;
use EC\Poetry\Messages\Traits\WithTargetsTrait;
use EC\Poetry\Services\Settings;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Create a draft and publish a translation request in one shot.
 *
 * @package EC\Poetry\Messages\Requests
 */
class CreateTranslationRequest extends AbstractRequest
{
    use WithContactsTrait;
    use WithDetailsTrait;
    use WithSourceTrait;
    use WithReturnAddressTrait;
    use WithTargetsTrait;
    use WithReferenceDocumentsTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, Settings $settings)
    {
        parent::__construct($identifier, $settings);
        $this->getIdentifier()->setProduct('TRA');

        if ($settings->get('client.wsdl') && $settings->get('notification.username') && $settings->get('notification.password')) {
            $this->withReturnAddress()
              ->setAction('UPDATE')
              ->setType('webService')
              ->setUser($settings->get('notification.username'))
              ->setPassword($settings->get('notification.password'))
              ->setAddress($settings->get('client.wsdl'))
              ->setPath('handle');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::REQUEST_NEW_POST;
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        parent::getConstraints($metadata);
        $metadata->addPropertyConstraint('details', new Assert\Valid());
        $metadata->addPropertyConstraint('source', new Assert\Valid());
        $metadata->addPropertyConstraint('returnAddress', new Assert\Valid());
        $metadata->addPropertyConstraint('contacts', new Assert\Valid(['traverse' => true]));
        $metadata->addPropertyConstraint('targets', new Assert\Valid(['traverse' => true]));
        $metadata->addPropertyConstraint('referenceDocuments', new Assert\Valid(['traverse' => true]));
    }
}
