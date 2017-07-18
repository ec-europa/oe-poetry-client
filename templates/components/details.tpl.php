<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Components\Details $component
 */
?>
<demande>
    <?php if ($component->getClientId()) : ?>
        <userReference><?= $component->getClientId() ?></userReference>
    <?php endif ?>
    <?php if ($component->getApplicationId()) : ?>
        <applicationReference><?= $component->getApplicationId() ?></applicationReference>
    <?php endif ?>
    <?php if ($component->getAuthor()) : ?>
        <organisationAuteur><?= $component->getAuthor() ?></organisationAuteur>
    <?php endif ?>
    <?php if ($component->getRequester()) : ?>
        <serviceDemandeur><?= $component->getRequester() ?></serviceDemandeur>
    <?php endif ?>
    <?php if ($component->getTitle()) : ?>
        <titre><?= $component->getTitle() ?></titre>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <remarque><?= $component->getRemark() ?></remarque>
    <?php endif ?>
    <?php if ($component->getType()) : ?>
        <type><?= $component->getType() ?></type>
    <?php endif ?>
    <?php if ($component->getDestination()) : ?>
        <destination><?= $component->getDestination() ?></destination>
    <?php endif ?>
    <?php if ($component->getProcedure()) : ?>
        <procedure><?= $component->getProcedure() ?></procedure>
    <?php endif ?>
    <?php if ($component->getDelai()) : ?>
        <delai><?= $component->getDelai() ?></delai>
    <?php endif ?>
    <?php if ($component->getRequestDate()) : ?>
        <dateDemande><?= $component->getRequestDate() ?></dateDemande>
    <?php endif ?>
    <?php if ($component->getStatus()) : ?>
        <statusDemande><?= $component->getStatus() ?></statusDemande>
    <?php endif ?>
    <?php if ($component->getInterServices()) : ?>
        <consultationInterServices><?= $component->getInterServices() ?></consultationInterServices>
    <?php endif ?>
    <?php if ($component->getInterInstitution()) : ?>
        <procedureInterInstitution><?= $component->getInterInstitution() ?></procedureInterInstitution>
    <?php endif ?>
    <?php if ($component->getReferenceFilesRemark()) : ?>
        <referenceFilesNote><?= $component->getReferenceFilesRemark() ?></referenceFilesNote>
    <?php endif ?>
</demande>
