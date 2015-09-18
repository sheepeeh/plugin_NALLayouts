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

$exhibit = get_current_record('exhibit');
 $exhibitUrl = exhibit_builder_exhibit_uri($exhibit);
 $exhibitUrll = $exhibitUrl . "item/";


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

<script type="text/javascript">

    jQuery(document).ready(function() {
    /* Code to make fancybox more accessible 
    Be sure to also set .fancybox-nav span's visibility to "visible" so buttons are shown without the mouse. */
    jQuery('.fancybox').fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        prevEffect : 'none',
        nextEffect : 'none',

        // Show the close button
        closeBtn  : true,


        // Stop enter key from going to next image in gallery
        keys : {
            next : {
                34 : 'up',   // page down
                39 : 'left', // right arrow
                40 : 'up'    // down arrow
            },
            prev : {
                8  : 'right',  // backspace
                33 : 'down',   // page up
                37 : 'right',  // left arrow
                38 : 'down'    // up arrow
            },
            close  : [27], // escape key
            play   : [32], // space - start/stop slideshow
            toggle : [70]  // letter "f" - toggle fullscreen
        },

        helpers : {
            title : {
                type : 'inside'
            },
            buttons : {}
        },


        // Set the fancybox image alt text to the parent image's alt text
        beforeShow : function() {
            var alt = this.element.find('img').attr('alt');                    
            this.inner.find('img').attr('alt', alt);                                
        },

        // Move keyboard focus to the next button
        afterShow: function(){
            jQuery('.fancybox-next').focus();
        },

        // Set up content for the fancybox caption
        afterLoad : function() {          
            var itemHref = <?php echo '"' . $exhibitUrl . '"'; ?> + "/item/" + this.element.parent().parent().find('div.item-file').attr('item-id');
            var itemTitle = '<h3>' + this.element.parent().find('img').attr('title') + '</h2>';
            var itemLink = '<a href="' + itemHref + '" target="_blank">View more information about this item (opens in new window).</a>';
            var itemCount = '<span class="item-count">Item ' + (this.index + 1) + ' of ' + this.group.length + '</span>';
            this.title = itemCount + "<br>" + itemTitle + itemLink ;               
        },

         // Return focus to the element used to open the fancybox
         afterClose: function() {
            jQuery(this.element).focus();
        }
    });
});

</script>
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

                       $itemID = metadata($item, 'id');

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
                            $fileOptions['linkAttributes']['href'] = file_display_url($file,'fullsize');
                            $fileOptions['linkAttributes']['alt'] = "View more information about $title.";
                            $fileOptions['linkAttributes']['title'] = "View more information about this item.";
                            $fileOptions['linkAttributes']['data-lightbox'] = "lightbox-gallery";

                            $image = file_image($size, $fileOptions['imgAttributes'], $file);
                            $html = "<div class='item-file' item-id='$itemID'>". exhibit_builder_link_to_exhibit_item($image, array('alt' => 'View a larger image.', 'class' => 'fancybox download-file', 'data-fancybox-group' => 'gallery'), $item) . "</div>";
                            // $html = "<div class=\"item-file\"><a href=\"" . file_display_url($file,'fullsize') . "\" alt=\"View more information about this item.\" data-lightbox=\"lightbox-gallery\" class=\"exhibit-item-link\">" .$image."</a></div>";
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
                            $itemID = metadata($item, 'id');
                           
                            if (in_array("show-title", $showMetadata)) { 
                                // This doubles the images in the gallery--need to figure out how  to suppress dublicates
                                // . exhibit_builder_link_to_exhibit_item($title, array('alt' => 'View a larger image.', 'class' => 'fancybox', 'data-fancybox-group' => 'gallery'), $item)
                                echo "<div class='exhibit-item-title' item-id='$itemID'>$title</div>"; 
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


