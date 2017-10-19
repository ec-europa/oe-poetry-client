<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Requests\CreateTranslationRequest $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => $message->getType(), 'communication' => $message->getCommunication()]) ?>
<?= $this->component($message->getIdentifier()); ?>
<?php if ($message->getDetails()) : ?>
    <?= $this->component($message->getDetails()); ?>
<?php endif; ?>
<?php if ($message->getContacts()) : ?>
    <?php foreach ($message->getContacts() as $contact) : ?>
        <?= $this->component($contact); ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ($message->getReturnAddress()) : ?>
    <?= $this->component($message->getReturnAddress()); ?>
<?php endif; ?>
<?php if ($message->getSource()) : ?>
    <?= $this->component($message->getSource()); ?>
<?php endif; ?>
<?php if ($message->getTargets()) : ?>
    <?php foreach ($message->getTargets() as $target) : ?>
        <?= $this->component($target); ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ($message->getReferenceDocuments()) : ?>
    <?php foreach ($message->getReferenceDocuments() as $referenceDocument) : ?>
        <?= $this->component($referenceDocument); ?>
    <?php endforeach; ?>
<?php endif;

