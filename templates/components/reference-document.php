<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\ReferenceDocument $component
 */
?>
<documentReference <?= $this->attributes($component->getAttributes()) ?>>
    <documentReferenceName><?= $component->getName() ?></documentReferenceName>
    <?php if ($component->getPath()) : ?>
        <documentReferencePath><?= $component->getPath() ?></documentReferencePath>
    <?php endif ?>
    <?php if ($component->getSize()) : ?>
        <documentReferenceSize><?= $component->getSize() ?></documentReferenceSize>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <documentReferenceRemark><?= $component->getRemark() ?></documentReferenceRemark>
    <?php endif ?>
    <documentReferenceFile><?= $component->getFile() ?></documentReferenceFile>
</documentReference>
