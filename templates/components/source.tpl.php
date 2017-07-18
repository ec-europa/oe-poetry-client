<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Components\Source $component
 */
?>
<documentSource <?= $this->attributes($component->getAttributes()) ?>>
    <documentSourceName><?= $component->getName() ?></documentSourceName>
    <?php if ($component->getPath()) : ?>
        <documentSourcePath><?= $component->getPath() ?></documentSourcePath>
    <?php endif ?>
</documentSource>
