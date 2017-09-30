<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Identifier $component
 */
?>
<demandeId>
    <codeDemandeur><?= $component->getCode() ?></codeDemandeur>
    <annee><?= $component->getYear() ?></annee>
    <?php if ($component->getNumber()) : ?>
        <numero><?= $component->getNumber() ?></numero>
    <?php endif; ?>
    <?php if ($component->getSequence()) : ?>
        <sequence><?= $component->getSequence() ?></sequence>
    <?php endif; ?>
    <version><?= $component->getVersion() ?></version>
    <partie><?= $component->getPart() ?></partie>
    <produit><?= $component->getProduct() ?></produit>
</demandeId>

