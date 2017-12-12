<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Target $component
 */
?>
<attributions
    <?php if ($component->getAction()) : ?>
        action="<?= $this->escape($component->getAction()) ?>"
    <?php endif ?>
    format="<?= $this->escape($component->getFormat()) ?>" lgCode="<?= $this->escape($component->getLanguage()) ?>">
    <?php if ($component->getRemark()) : ?>
        <attributionsRemark><![CDATA[<?= $component->getRemark() ?>]]></attributionsRemark>
    <?php endif ?>
    <?php if ($component->getDelay()) : ?>
        <attributionsDelai
        <?php if ($component->getDelayFormat()) : ?>
            format="<?= $this->escape($component->getDelayFormat()) ?>"
        <?php endif ?>><![CDATA[<?= $component->getDelay() ?>]]></attributionsDelai>
    <?php endif ?>
    <?php if ($component->getAcceptedDelay()) : ?>
        <attributionsDelaiAccepted
        <?php if ($component->getAcceptedDelayFormat()) : ?>
            format="<?= $this->escape($component->getAcceptedDelayFormat()) ?>"
        <?php endif ?>><![CDATA[<?= $component->getAcceptedDelay() ?>]]></attributionsDelaiAccepted>
    <?php endif ?>
    <?php if ($component->getReturnAddresses()) : ?>
        <?php foreach ($component->getReturnAddresses() as $address) : ?>
            <?= $this->component($address); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($component->getTranslatedFile()) : ?>
        <attributionsFile><![CDATA[<?= $component->getTranslatedFile() ?>]]></attributionsFile>
    <?php endif ?>
    <?php if ($component->getContacts()) : ?>
        <?php foreach ($component->getContacts() as $contact) : ?>
            <?= $this->component($contact); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</attributions>
