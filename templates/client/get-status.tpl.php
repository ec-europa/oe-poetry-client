<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Client\GetStatus $message
 * @var string $identifier
 */
?>
<?php $this->layout('layout', ['identifier' => $identifier, 'type' => 'getStatus']) ?>
<?php $this->insert('components::identifier', ['message' => $message->getIdentifier()]) ?>
<status>
  <attribute>A</attribute>
  <attribute>B</attribute>
  <attribute>C</attribute>
</status>
