<?php
$formStem = $block->getFormStem();
$options = $block->getOptions();
?>
<style>
 .metadata-display > label {
    display:inline-block;
 }
 </style>
<div class="selected-items">
    <h4><?php echo __('Items'); ?></h4>
    <?php echo $this->exhibitFormAttachments($block); ?>
</div>

