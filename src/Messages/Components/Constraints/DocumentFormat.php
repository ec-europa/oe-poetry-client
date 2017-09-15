<?php

namespace EC\Poetry\Messages\Components\Constraints;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\ChoiceValidator;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @package EC\Poetry\Messages\Components\Constraints
 */
class DocumentFormat extends Choice
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct([
            'DOC',
            'DOCX',
            'HTM',
            'HTML',
            'PDF',
            'PPT',
            'RTF',
            'TIF',
            'TIFF',
            'TXT',
            'USB',
            'VSD',
            'XLS',
            'XML',
            'XMW',
            'ZIP',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return ChoiceValidator::class;
    }
}
