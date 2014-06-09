<div class="gallery <?php if ($showcaseFile || !empty($text)) echo "with-showcase $galleryPosition"; ?>">
    <?php foreach ($attachments as $attachment): ?>
		<?php $item = $attachment->getItem(); ?>
		<div class="exhibit-item exhibit-gallery-item">
		<div class="gallery-item-title">
		<?php echo metadata($item, array("Dublin Core", "Title"), array('snippet'=>100)); ?>
		</div>
		<?php echo $this->exhibitAttachment($attachment); ?>
		</div>
	<?php endforeach; ?>
</div>
<?php echo $text; ?>

