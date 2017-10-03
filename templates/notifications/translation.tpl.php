<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Notifications\TranslationReceived $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'translation', 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php foreach ($message->getTargets() as $target) : ?>
    <?= $this->component($target); ?>
<?php endforeach;
