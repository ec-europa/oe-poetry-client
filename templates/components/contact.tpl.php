<?php
/**
 * @file
 * Template file.
 *
 * @var \League\Plates\Template\Template $this
 * @var \EC\Poetry\Messages\Components\Contact $component
 */
?>
<contacts>
    <contactNickname><?= $component->getNickname() ?></contactNickname>
    <?php if ($component->getEmail()) : ?>
        <contactEmail><?= $component->getEmail() ?></contactEmail>
    <?php endif ?>
</contacts>
