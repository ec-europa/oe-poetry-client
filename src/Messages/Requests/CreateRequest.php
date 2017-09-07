<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Requests\Traits\WithContactsTrait;
use EC\Poetry\Messages\Requests\Traits\WithDetailsTrait;
use EC\Poetry\Messages\Requests\Traits\WithReferenceDocumentsTrait;
use EC\Poetry\Messages\Requests\Traits\WithReturnAddressTrait;
use EC\Poetry\Messages\Requests\Traits\WithSourceTrait;
use EC\Poetry\Messages\Requests\Traits\WithTargetsTrait;
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
