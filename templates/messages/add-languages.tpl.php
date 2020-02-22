<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Requests\AddLanguagesRequest $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => $message->getType(), 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php if ($message->getDetails()) : ?>
    <?= $this->component($message->getDetails()); ?>
<?php endif; ?>
<?php if ($message->getTargets()) : ?>
    <?php foreach ($message->getTargets() as $target) : ?>
        <?= $this->component($target); ?>
    <?php endforeach; ?>
<?php endif;
