<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\ReturnAddress $component
 */
?>
<attributionsSend <?= $this->attributes($component->getAttributes()) ?>>
    <?php if ($component->getUser()) : ?>
        <retourUser><![CDATA[<?= $component->getUser() ?>]]></retourUser>
    <?php endif ?>
    <retourAddress><![CDATA[<?= $component->getAddress() ?>]]></retourAddress>
    <?php if ($component->getPath()) : ?>
        <retourPath><![CDATA[<?= $component->getPath() ?>]]></retourPath>
    <?php endif ?>
</attributionsSend>
