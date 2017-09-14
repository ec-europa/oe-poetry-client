<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Responses\Status $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'status', 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php foreach ($message->getStatuses() as $status) : ?>
    <?= $this->component($status); ?>
<?php endforeach;
