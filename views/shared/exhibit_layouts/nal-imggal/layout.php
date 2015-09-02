<?php
$showcasePosition = isset($options['showcase-position'])
? html_escape($options['showcase-position'])
: 'none';
$showcaseFile = $showcasePosition !== 'none' && !empty($attachments);
$galleryPosition = isset($options['gallery-position'])
? html_escape($options['gallery-position'])
: 'left';

$size = isset($options['file-size'])
? html_escape($options['file-size'])
: 'thumbnail';

$width = isset($options['img-width'])
? html_escape($options['img-width'])
: '';
$showMetadata = isset($options['metadata-display'])
? ($options['metadata-display'])
: '';

?>
<?php if ($showcaseFile): ?>
    <div class="gallery-showcase <?php echo $showcasePosition; ?> with-<?php echo $galleryPosition; ?>">
        <?php
        $attachment = array_shift($attachments);
        echo $this->exhibitAttachment($attachment, array('imageSize' => 'fullsize'), null, true);
        ?>
    </div>
<?php endif; ?>
<div class="gallery <?php if ($showcaseFile) echo "with-showcase $galleryPosition"; ?>">
    <div style="text-align:left;"><?php echo $this->shortcodes($text); ?>
    </div>
    <?php $counter = 0; ?>
    <?php if (count($attachments) > 0): ?>
        <?php foreach ($attachments as $attachment): ?>
            <?php $item = $attachment->getItem(); ?>
            <?php $file = $attachment->getFile(); ?>
            <?php $title = metadata($item, array("Dublin Core", "Title")); ?>
            <?php if ($counter == 0): ?>
                <div id="imggal-row">
                <?php endif; ?>
                <?php $counter++; ?>

                <div class="exhibit-item exhibit-gallery-item" style=<?php echo '"width:' . $width . '"' ;?>>
                    <?php if (metadata($item, 'has thumbnail')): ?>
                       <?php 
                       if (metadata($file, 'MIME Type') == 'application/pdf' && $size == 'fullsize' && $width != "N/A" && !isMobile()) {
                            echo file_markup($file);
                       } else {
                            // echo attachment image

                            // if  ($description = (metadata($item, array("Dublin Core", "Description")))) {
                            //     $altTitle = $description;
                            // } elseif ($caption = $attachment['caption']) {
                            //     $altTitle = $caption;
                            // } else {
                            //     $altTitle = $title;                            
                            // }

                            // $altText = "Thumbnail for '$altTitle'."; 
                            $fileOptions = array();

                            $fileOptions['imgAttributes']['alt'] = "Thumbnail for the first (or only) page of $title.";
                            $fileOptions['imgAttributes']['title'] = $title;
                            $fileOptions['imageSize'] = $size;
                            $fileOptions['linkAttributes']['href'] = exhibit_builder_exhibit_item_uri($item);
                            $fileOptions['linkAttributes']['alt'] = "View more information about $title.";
                            $fileOptions['linkAttributes']['title'] = "View more information about this item.";

                            $image = file_image($size, $fileOptions['imgAttributes'], $file);
                            $html = "<div class='item-file'>" . exhibit_builder_link_to_exhibit_item($image, array('alt' => 'View more information about this item.'), $item) . "</div>";
                            echo $html;
                        }
                            ?>
                    <?php endif; ?>

                <?php if ($attachment['caption'] || !empty($showMetadata)): ?>
                    <div class="exhibit-item-caption">

                        <?php //echo caption and selected metadata elements
                        
                        if ($attachment['caption'] && empty($showMetadata)) { 
                            echo $attachment['caption']; 
                        }

                        if (!empty($showMetadata)) {
                           
                            if (in_array("show-title", $showMetadata)) { 
                                echo "<div class='exhibit-item-title'><a href="
                                .exhibit_builder_exhibit_item_uri($item)." alt='Link to individual item page.' title='View more information about this item.'>".metadata($item, array("Dublin Core", "Title"), 
                                    array('snippet'=>100))."</a></div>"; 
                            }                   
                            if (in_array("show-date", $showMetadata) && is_null(metadata($item, array("Dublin Core", "Date"))) == false) { 
                                echo "<div class='exhibit-item-date'>("
                                    .metadata($item, array("Dublin Core", "Date"), 
                                        array('snippet'=>50)) . ")</div>";
                            }
                            if ($attachment['caption']) { 
                                echo $attachment['caption']; 
                            }
                            if (in_array("show-desc", $showMetadata) && is_null(metadata($item, array('Dublin Core', 'Description'))) == false) { 
                                echo '<div class="exhibit-item-description">'
                                .metadata($item, array("Dublin Core", "Description"), array('snippet'=>150))."</div>";
                            }
                            if (in_array("show-script", $showMetadata) && is_null(metadata($item, array("Item Type Metadata","Transcription"))) == false) { 
                                echo "<div class='exhibit-item-transcript'>"
                                .metadata($item, array("Item Type Metadata","Transcription"),array('snippet'=>150))."</div>"; 
                        }
                    } ?>

</div>
<?php endif; ?>

</div>

<?php 
// break every 4 images and insert a dividing line
if ($counter % 4 == 0 && $attachment != end($attachments)): ?>
</div>
<span class="break-row"></span>
<div id="imggal-row">
<?php endif; ?>
<?php if ($attachment == end($attachments)) { echo "</div>";} ?>

<?php endforeach; ?>
<?php endif; ?>
</div>
<!-- </div> -->


