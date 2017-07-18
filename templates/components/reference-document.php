<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Components\ReferenceDocument $component
 */
?>
<documentReference>
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
