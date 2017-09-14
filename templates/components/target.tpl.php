<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\Attribution $component
 */
?>
<attributions action="<?= $component->getAction() ?>" format="<?= $component->getFormat() ?>" lgCode="<?= $component->getLanguage() ?>">
    <attributionsDelai format="DD/MM/YYYY"><?= $component->getDelay() ?></attributionsDelai>
</attributions>
