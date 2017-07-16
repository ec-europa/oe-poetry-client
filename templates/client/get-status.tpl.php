<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Client\GetStatus $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'getStatus']) ?>
<?= $this->component($message->getIdentifier()) ?>
<status>
  <attribute>A</attribute>
  <attribute>B</attribute>
  <attribute>C</attribute>
</status>
