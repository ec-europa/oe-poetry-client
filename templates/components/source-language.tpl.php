<?php
/**
 * @file
 * Template file.
 *
 * @var \EC\Poetry\Services\Plates\Template $this
 * @var \EC\Poetry\Messages\Components\SourceLanguage $component
 */
?>
<documentSourceLang lgCode="<?= $this->escape($component->getCode()) ?>">
    <documentSourceLangPages><![CDATA[<?= $component->getPages() ?>]]></documentSourceLangPages>
</documentSourceLang>
