<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Status $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'status']) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php foreach ($message->getStatuses() as $status) : ?>
    <?= $this->component($status); ?>
<?php endforeach;
