<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Contact $component
 */
?>
<contacts>
    <contactNickname><?= $component->getNickname() ?></contactNickname>
    <?php if ($component->getEmail()) : ?>
        <contactEmail><?= $component->getEmail() ?></contactEmail>
    <?php endif ?>
</contacts>
