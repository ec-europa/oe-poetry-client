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
        action="<?= $component->getAction() ?>"
    <?php endif ?>
    format="<?= $component->getFormat() ?>" lgCode="<?= $component->getLanguage() ?>">
    <?php if ($component->getRemark()) : ?>
        <attributionsRemark><?= $component->getRemark() ?></attributionsRemark>
    <?php endif ?>
    <?php if ($component->getDelay()) : ?>
        <attributionsDelai
            <?php if ($component->getDelayFormat()) : ?>
                format="<?= $component->getDelayFormat() ?>"
            <?php endif ?>
        ><?= $component->getDelay() ?></attributionsDelai>
    <?php endif ?>
    <?php if ($component->getAcceptedDelay()) : ?>
        <attributionsDelaiAccepted
            <?php if ($component->getAcceptedDelayFormat()) : ?>
                format="<?= $component->getAcceptedDelayFormat() ?>"
            <?php endif ?>
        ><?= $component->getAcceptedDelay() ?></attributionsDelaiAccepted>
    <?php endif ?>
    <?php if ($component->getReturnAddresses()) : ?>
        <?php foreach ($component->getReturnAddresses() as $address) : ?>
            <?= $this->component($address); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($component->getTranslatedFile()) : ?>
        <attributionsFile><?= $component->getTranslatedFile() ?></attributionsFile>
    <?php endif ?>
    <?php if ($component->getContacts()) : ?>
        <?php foreach ($component->getContacts() as $contact) : ?>
            <?= $this->component($contact); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</attributions>
