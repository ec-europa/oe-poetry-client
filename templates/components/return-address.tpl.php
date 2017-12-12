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
        <retourUser><![CDATA[<?= $component->getUser() ?>]]></retourUser>
    <?php endif ?>
    <?php if ($component->getPassword()) : ?>
        <retourPassword><![CDATA[<?= $component->getPassword() ?>]]></retourPassword>
    <?php endif ?>
    <retourAddress><![CDATA[<?= $component->getAddress() ?>]]></retourAddress>
    <?php if ($component->getPath()) : ?>
        <retourPath><![CDATA[<?= $component->getPath() ?>]]></retourPath>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <retourRemark><![CDATA[<?= $component->getRemark() ?>]]></retourRemark>
    <?php endif ?>
</retour>