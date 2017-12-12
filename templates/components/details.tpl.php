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
        <userReference><![CDATA[<?= $component->getClientId() ?>]]></userReference>
    <?php endif ?>
    <?php if ($component->getTitle()) : ?>
        <titre><![CDATA[<?= $component->getTitle() ?>]]></titre>
    <?php endif ?>
    <?php if ($component->getResponsible()) : ?>
        <organisationResponsable><![CDATA[<?= $component->getResponsible() ?>]]></organisationResponsable>
    <?php endif ?>
    <?php if ($component->getAuthor()) : ?>
        <organisationAuteur><![CDATA[<?= $component->getAuthor() ?>]]></organisationAuteur>
    <?php endif ?>
    <?php if ($component->getRequester()) : ?>
        <serviceDemandeur><![CDATA[<?= $component->getRequester() ?>]]></serviceDemandeur>
    <?php endif ?>
    <?php if ($component->getApplicationId()) : ?>
        <applicationReference><![CDATA[<?= $component->getApplicationId() ?>]]></applicationReference>
    <?php endif ?>
    <?php if ($component->getRemark()) : ?>
        <remarque><![CDATA[<?= $component->getRemark() ?>]]></remarque>
    <?php endif ?>
    <?php if ($component->getDelay()) : ?>
        <delai><![CDATA[<?= $component->getDelay() ?>]]></delai>
    <?php endif ?>
    <?php if ($component->getRequestDate()) : ?>
        <dateDemande><![CDATA[<?= $component->getRequestDate() ?>]]></dateDemande>
    <?php endif ?>
    <?php if ($component->getStatus()) : ?>
        <statusDemande><![CDATA[<?= $component->getStatus() ?>]]></statusDemande>
    <?php endif ?>
    <?php if ($component->getInterServices()) : ?>
        <consultationInterServices><![CDATA[<?= $component->getInterServices() ?>]]></consultationInterServices>
    <?php endif ?>
    <?php if ($component->getInterInstitution()) : ?>
        <procedureInterInstitution><![CDATA[<?= $component->getInterInstitution() ?>]]></procedureInterInstitution>
    <?php endif ?>
    <?php if ($component->getReferenceFilesRemark()) : ?>
        <referenceFilesNote><![CDATA[<?= $component->getReferenceFilesRemark() ?>]]></referenceFilesNote>
    <?php endif ?>
    <?php if ($component->getProcedure()) : ?>
        <procedure id="<?= $this->escape($component->getProcedure()) ?>"/>
    <?php endif ?>
    <?php if ($component->getDestination()) : ?>
        <destination id="<?= $this->escape($component->getDestination()) ?>"/>
    <?php endif ?>
    <?php if ($component->getType()) : ?>
        <type id="<?= $this->escape($component->getType()) ?>"/>
    <?php endif ?>
    <?php if ($component->getWorkflowCode()) : ?>
        <workflowCode><![CDATA[<?= $component->getWorkflowCode() ?>]]></workflowCode>
    <?php endif ?>
</demande>
