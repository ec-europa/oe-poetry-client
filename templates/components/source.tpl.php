<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Source $component
 */
?>
<documentSource <?= $this->attributes($component->getAttributes()) ?>>
    <documentSourceName><![CDATA[<?= $component->getName() ?>]]></documentSourceName>
    <documentSourceFile><![CDATA[<?= $component->getFile() ?>]]></documentSourceFile>
    <?php if ($component->getPath()) : ?>
        <documentSourcePath><![CDATA[<?= $component->getPath() ?>]]></documentSourcePath>
    <?php endif ?>
    <?php if ($component->getSourceLanguages()) : ?>
        <?php foreach ($component->getSourceLanguages() as $target) : ?>
            <?= $this->component($target); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($component->getSize()) : ?>
        <documentSourceSize><![CDATA[<?= $component->getSize() ?>]]></documentSourceSize>
    <?php endif ?>
</documentSource>
