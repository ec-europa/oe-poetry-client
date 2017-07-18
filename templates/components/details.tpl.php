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
  <userReference><?= $component->getClientID() ?></userReference>
  <applicationReference><?= $component->getApplicationID() ?></applicationReference>
  <organisationAuteur><?= $component->getAuthor() ?></organisationAuteur>
  <serviceDemandeur><?= $component->getRequester() ?></serviceDemandeur>
  <titre><?= $component->getTitle() ?></titre>
  <remarque><?= $component->getRemark() ?></remarque>
  <type><?= $component->getType() ?></type>
  <destination><?= $component->getDestination() ?></destination>
  <procedure><?= $component->getProcedure() ?></procedure>
  <delai><?= $component->getDelai() ?></delai>
  <dateDemande><?= $component->getRequestDate() ?></dateDemande>
  <statusDemande><?= $component->getStatus() ?></statusDemande>
  <consultationInterServices><?= $component->getInterServices() ?></consultationInterServices>
  <procedureInterInstitution><?= $component->getInterInstitution() ?></procedureInterInstitution>
  <referenceFilesNote><?= $component->getReferenceFilesRemark() ?></referenceFilesNote>
</demande>
