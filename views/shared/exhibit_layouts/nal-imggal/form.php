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

<div class="block-text">
    <h4><?php echo __('Text'); ?></h4>
    <?php echo $this->exhibitFormText($block); ?>
</div>

<div class="layout-options">
    <div class="block-header">
        <h4><?php echo __('Layout Options'); ?></h4>
        <div class="drawer"></div>
    </div>

    <div class="showcase-position">
        <?php echo $this->formLabel($formStem . '[options][showcase-position]', __('Showcase file position')); ?>
        <?php
        echo $this->formSelect($formStem . '[options][showcase-position]',
            @$options['showcase-position'], array(),
            array(
                'none' => __('No showcase file'),
                'left' => __('Left'),
                'right' => __('Right')
            )
        );
        ?>
    </div>


    <div class="gallery-position">
        <?php echo $this->formLabel($formStem . '[options][gallery-position]', __('Gallery position')); ?>
        <?php
        echo $this->formSelect($formStem . '[options][gallery-position]',
            @$options['gallery-position'], array(),
            array(
                'left' => __('Left'),
                'right' => __('Right')
            )
        );
        ?>
        <p class="instructions"><?php echo __('If there is no showcase file the gallery will use the full width of the page.'); ?></p>
    </div>

    <div class="file-size">
        <?php echo $this->formLabel($formStem . '[options][file-size]', __('File size')); ?>
        <?php
        echo $this->formSelect($formStem . '[options][file-size]',
            @$options['file-size'], array(),
            array(
                'thumbnail' => __('Thumbnail'),
                'fullsize' => __('Fullsize'),
                'square_thumbnail' => __('Square Thumbnail')
                ));
                ?>
    </div>
    <div class="image-width">
        <?php echo $this->formLabel($formStem . '[options][img-width]', __('Image Width')); ?>
        <?php
        echo $this->formSelect($formStem . '[options][img-width]',
            @$options['img-width'], array(),
            array(
                ' ' => "N/A",
                '90%' => __('90%'),
                '75%' => __('75%'),
                '50%' => __('50%')
                ));
                ?>
            <p class="instructions"><?php echo __('Only use this if the gallery contains only one single item.'); ?></p>
    </div>

    <div class="metadata-display">
        <?php echo $this->formLabel($formStem . '[options][metadata-display]', __('Display these elements:')). '<br />'; ?>
        <?php
        echo $this->formMultiCheckbox($formStem . '[options][metadata-display]',
            @$options['metadata-display'], array('listsep' => '&nbsp;'),
            array(
                "show-title" => " Title",
                "show-date" => " Date",
                "show-desc" => " Description",
                "show-script" => " Transcription"
                ));
                ?>
         
            <p class="instructions"><?php echo __('Check the boxes next to the elements you want to display in the caption area for elements in this block.'); ?></p>
    </div>

</div>
