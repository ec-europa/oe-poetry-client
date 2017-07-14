<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Client\GetStatus $message
 */
?><?='<?xml version="1.0" encoding="utf-8"?>'?>
<POETRY xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://intragate.ec.europa.eu/DGT/poetry_services/poetry.xsd">
  <request communication="asynchrone" id="<?= $message->getIdentifier()->getFormattedIdentifier() ?>" type="getStatus">
    <?php $this->insert('components::identifier', ['message' => $message->getIdentifier()]) ?>
  </request>
</POETRY>
