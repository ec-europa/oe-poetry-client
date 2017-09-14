<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Components\Traits\WithContactsTrait;
use EC\Poetry\Messages\Components\Traits\WithDetailsTrait;
use EC\Poetry\Messages\Components\Traits\WithReferenceDocumentsTrait;
use EC\Poetry\Messages\Components\Traits\WithReturnAddressTrait;
use EC\Poetry\Messages\Components\Traits\WithSourceTrait;
use EC\Poetry\Messages\Components\Traits\WithTargetsTrait;
use EC\Poetry\Messages\Components\Traits\WithAttributionsTrait;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Create a draft and publish a translation request in one shot.
 *
 * @package EC\Poetry\Messages\Requests
 */
class CreateRequest extends AbstractRequest
{
    use WithContactsTrait;
    use WithDetailsTrait;
    use WithSourceTrait;
    use WithReturnAddressTrait;
    use WithTargetsTrait;
    use WithReferenceDocumentsTrait;
    use WithAttributionsTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier)
    {
        parent::__construct($identifier);
        $identifier->setProduct('TRA');
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
