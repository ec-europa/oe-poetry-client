<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Details $component
 */
?>
<demande>
    <?php if ($component->getClientId()) : ?>
        <userReference><?= $component->getClientId() ?></userReference>
    <?php endif ?>
    <?php if ($component->getTitle()) : ?>
        <titre><?= $component->getTitle() ?></titre>
    <?php endif ?>
    <?php if ($component->getResponsible()) : ?>
        <organisationResponsable><?= $component->getResponsible() ?></organisationResponsable>
    <?php endif ?>
    <?php if ($component->getAuthor()) : ?>
        <organisationAuteur><?= $component->getAuthor() ?></organisationAuteur>
    <?php endif ?>
    <?php if ($component->getRequester()) : ?>
        <serviceDemandeur><?= $component->getRequester() ?></serviceDemandeur>
    <?php endif ?>
    <?php if ($component->getApplicationId()) : ?>
        <applicationReference><?= $component->getApplicationId() ?></applicationReference>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <remarque><?= $component->getRemark() ?></remarque>
    <?php endif ?>
    <?php if ($component->getDelay()) : ?>
        <delai><?= $component->getDelay() ?></delai>
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
    <?php if ($component->getProcedure()) : ?>
        <procedure id="<?= $component->getProcedure() ?>"/>
    <?php endif ?>
    <?php if ($component->getDestination()) : ?>
        <destination id="<?= $component->getDestination() ?>"/>
    <?php endif ?>
    <?php if ($component->getType()) : ?>
        <type id="<?= $component->getType() ?>"/>
    <?php endif ?>
    <?php if ($component->getWorkflowCode()) : ?>
        <workflowCode><?= $component->getWorkflowCode() ?></workflowCode>
    <?php endif ?>
</demande>
