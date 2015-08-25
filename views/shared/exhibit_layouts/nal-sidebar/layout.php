<?php
$size = isset($options['file-size'])
? html_escape($options['file-size'])
: 'square_thumbnail';

$fileOptions = array();
?>
<div id="sidebar-items">
    <ul class="items-list">
        <?php foreach ($attachments as $attachment): ?>
            <?php $item = $attachment->getItem(); ?>
            <?php $file = $attachment->getFile(); ?>

            <li>
                <?php if (metadata($item, 'has thumbnail')): ?>
                    <?php 
                    if (metadata($item,'item_type_id') == 6) {
                        $fileOptions['imgAttributes']['alt'] = 'Image (illustration or photograph) for this item, linking to the individual item page.';
                    } else {
                       $fileOptions['imgAttributes']['alt'] = 'Image for the first content page of the item, linking to the the individual item page.';
                   } 

                   if (!isset($fileOptions['imgAttributes']['title'])) {
                    $fileOptions['imgAttributes']['title'] = metadata($item, array('Dublin Core', 'Title'), array('no_escape' => true));
                }

                $imageSize = isset($fileOptions['imageSize'])
                ? $fileOptions['imageSize']
                : 'square_thumbnail';

                $fileOptions['imgAttributes']['width'] = "50px";
                $fileOptions['imgAttributes']['height'] = "50px";

                $image = file_image($imageSize, $fileOptions['imgAttributes'], $file);
                $html = "<div class='item-file'>" . exhibit_builder_link_to_exhibit_item($image, array('alt' => 'View more information about this item.'), $item) . "</div>";


                echo $html;

                ?>
            <?php endif; ?>

            <?php echo "<div class='item-title'><a class='permalink' alt='Link to individual item page.' href="
            .exhibit_builder_exhibit_item_uri($item).">".metadata($item, array("Dublin Core", "Title"), 
            array('snippet'=>100))."</a></div>"; ?>
        </li>

    <?php endforeach; ?>

</ul>
</div>


