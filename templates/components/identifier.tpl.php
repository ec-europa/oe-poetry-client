<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Components\Identifier $message
 */
?>
<demandeId>
    <codeDemandeur><?= $this->e($message->getCode()) ?></codeDemandeur>
    <annee><?= $this->e($message->getYear()) ?></annee>
    <numero><?= $this->e($message->getNumber()) ?></numero>
    <version><?= $this->e($message->getVersion()) ?></version>
    <partie><?= $this->e($message->getPart()) ?></partie>
    <produit><?= $this->e($message->getProduct()) ?></produit>
</demandeId>

