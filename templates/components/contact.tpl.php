<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Contact $component
 */
?>
<contacts <?= $this->attributes($component->getAttributes()) ?>>
    <contactNickname><![CDATA[<?= $component->getNickname() ?>]]></contactNickname>
    <?php if ($component->getEmail()) : ?>
        <contactEmail><![CDATA[<?= $component->getEmail() ?>]]></contactEmail>
    <?php endif ?>
</contacts>
