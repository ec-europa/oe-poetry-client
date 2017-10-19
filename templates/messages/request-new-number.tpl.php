<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Requests\GetNewNumber $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => $message->getType(), 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier());
