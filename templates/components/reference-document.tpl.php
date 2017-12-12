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
    <documentReferenceName><![CDATA[<?= $component->getName() ?>]]></documentReferenceName>
    <?php if ($component->getPath()) : ?>
        <documentReferencePath><![CDATA[<?= $component->getPath() ?>]]></documentReferencePath>
    <?php endif ?>
    <?php if ($component->getSize()) : ?>
        <documentReferenceSize><![CDATA[<?= $component->getSize() ?>]]></documentReferenceSize>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <documentReferenceRemark><![CDATA[<?= $component->getRemark() ?>]]></documentReferenceRemark>
    <?php endif ?>
    <documentReferenceFile><![CDATA[<?= $component->getFile() ?>]]></documentReferenceFile>
</documentReference>
