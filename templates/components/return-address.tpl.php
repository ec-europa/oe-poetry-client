<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\ReturnAddress $component
 */
?>
<retour <?= $this->attributes($component->getAttributes()) ?>>
    <?php if ($component->getUser()) : ?>
        <retourUser><?= $component->getUser() ?></retourUser>
    <?php endif ?>
    <?php if ($component->getPassword()) : ?>
        <retourPassword><?= $component->getPassword() ?></retourPassword>
    <?php endif ?>
    <retourAddress><?= $component->getAddress() ?></retourAddress>
    <?php if ($component->getPath()) : ?>
        <retourPath><?= $component->getPath() ?></retourPath>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <retourRemark><?= $component->getRemark() ?></retourRemark>
    <?php endif ?>
</retour>
