<?php

/**
 * @file
 * Contains \EC\Poetry\Services\Plates\Template
 */

namespace EC\Poetry\Services\Plates;

use League\Plates\Template\Template as OriginalTemplate;
use EC\Poetry\Messages\ComponentInterface;

/**
 * Class Template.
 *
 * This class is not actually used it's just to allow proper IDE completion in
 * template files.
 *
 * @method component(ComponentInterface $component)
 * @method attributes(array $attributes)
 *
 * @package EC\Poetry\Services\Plates
 */
class Template extends OriginalTemplate
{

}
