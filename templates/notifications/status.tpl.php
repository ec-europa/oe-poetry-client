<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Notifications\StatusUpdated $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'status', 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php foreach ($message->getStatuses() as $target) : ?>
    <?= $this->component($target); ?>
<?php endforeach; ?>
<?php foreach ($message->getTargets() as $target) : ?>
    <?= $this->component($target); ?>
<?php endforeach;
