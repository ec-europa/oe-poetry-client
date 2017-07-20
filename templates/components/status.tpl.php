<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Status $component
 */
?>
<status <?= $this->attributes($component->getAttributes()) ?>>
    <statusDate><?= $component->getDate() ?></statusDate>
    <?php if ($component->getTime()) : ?>
        <statusTime><?= $component->getTime() ?></statusTime>
    <?php endif ?>
    <?php if ($component->getMessage()) : ?>
        <statusMessage><?= $component->getMessage() ?></statusMessage>
    <?php endif ?>
</status>
