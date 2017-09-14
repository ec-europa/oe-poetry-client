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
    <documentSourceName><?= $component->getName() ?></documentSourceName>
    <documentSourceFile><?= $component->getFile() ?></documentSourceFile>
    <?php if ($component->getPath()) : ?>
        <documentSourcePath><?= $component->getPath() ?></documentSourcePath>
    <?php endif ?>
    <?php foreach ($component->getLanguages() as $languageCode => $languagePages) : ?>
        <documentSourceLang lgCode="<?= $languageCode ?>"><documentSourceLangPages><?= $languagePages ?></documentSourceLangPages></documentSourceLang>
    <?php endforeach ?>
    <?php if ($component->getSize()) : ?>
        <documentSourceSize><?= $component->getSize() ?></documentSourceSize>
    <?php endif ?>
</documentSource>
