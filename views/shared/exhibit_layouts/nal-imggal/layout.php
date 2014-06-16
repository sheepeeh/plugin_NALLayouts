<?php
$showcasePosition = isset($options['showcase-position'])
    ? html_escape($options['showcase-position'])
    : 'none';
$showcaseFile = $showcasePosition !== 'none' && !empty($attachments);
$galleryPosition = isset($options['gallery-position'])
    ? html_escape($options['gallery-position'])
    : 'left';
?>
<?php if ($showcaseFile): ?>
<div class="gallery-showcase <?php echo $showcasePosition; ?> with-<?php echo $galleryPosition; ?>">
<?php
        $attachment = array_shift($attachments);
        echo $this->exhibitAttachment($attachment, array('imageSize' => 'fullsize'));
    ?>
</div>
<?php endif; ?>
<div class="gallery <?php if ($showcaseFile) echo "with-showcase $galleryPosition"; ?>">
<?php $counter = 0; ?>
  <?php foreach ($attachments as $attachment): ?>
        <?php $item = $attachment->getItem(); ?>
        <?php $file = $attachment->getFile(); ?>
      
            <?php $counter++; ?>
            <div class="exhibit-item exhibit-gallery-item">
            <?php echo file_markup($file,array('imageSize'=>'thumbnail')); ?>
            <div class="exhibit-item-title">
            <?php echo "<a href=".exhibit_builder_exhibit_item_uri($item).">".metadata($item, array("Dublin Core", "Title"), array('snippet'=>100))."</a>"; ?>
            <?php if (metadata($item, array("Dublin Core", "Date"))) { echo '<span class="exhibit-item-date"> (' . metadata($item, array("Dublin Core", "Date")) . ')</span>'; } ?>
           </div>
            <?php echo $attachment['caption'] ?>
            </div>
         
            <?php if ($counter % 4 == 0): ?>
                <div class="break-row"></div>
            <?php endif; ?>


        <?php endforeach; ?>
    </div>
<?php echo $text; ?>

