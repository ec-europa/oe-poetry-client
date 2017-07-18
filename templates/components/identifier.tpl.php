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
    <numero><?= $component->getNumber() ?></numero>
    <version><?= $component->getVersion() ?></version>
    <partie><?= $component->getPart() ?></partie>
    <produit><?= $component->getProduct() ?></produit>
</demandeId>

