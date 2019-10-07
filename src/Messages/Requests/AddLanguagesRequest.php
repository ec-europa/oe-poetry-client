<?php

namespace EC\Poetry\Messages\Requests;

use EC\Poetry\Messages\Components\Identifier;
use EC\Poetry\Messages\Traits\WithDetailsTrait;
use EC\Poetry\Messages\Traits\WithTargetsTrait;
use EC\Poetry\Services\Settings;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Add languages to a previous translation request.
 *
 * @package EC\Poetry\Messages\Requests
 */
class AddLanguagesRequest extends AbstractRequest
{
    use WithDetailsTrait;
    use WithTargetsTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, Settings $settings)
    {
        parent::__construct($identifier, $settings);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::REQUEST_MODIFICATION_POST;
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints(ClassMetadata $metadata)
    {
        parent::getConstraints($metadata);
        $metadata->addPropertyConstraint('targets', new Assert\Valid(['traverse' => true]));
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'messages::add-languages';
    }
}
