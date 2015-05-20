
<div id="sidebar-items">
    <ul class="items-list">
        <?php foreach ($attachments as $attachment): ?>
            <?php $item = $attachment->getItem(); ?>
            <?php $file = $attachment->getFile(); ?>

            <li>

                <?php if (metadata($item,'item_type_id') == 6) {
                    echo file_markup($file, array('imageSize' => 'square_thumbnail', 
                        'imgAttributes'=>array('alt'=>'Image (illustration or photograph) for this item, linking to the individual item page.', 
                            'height' => '50px', 
                            'width' => '50px',
                            'title'=>metadata($item, array('Dublin Core', 'Title')))));
                } else {
                    echo file_markup($file, array('imageSize' => 'square_thumbnail', 
                        'imgAttributes'=>array('alt'=>'Image for the first content page of the item, linking to the the individual item page.', 
                            'height' => '50px', 
                            'width' => '50px',
                            'title'=>metadata($item, array('Dublin Core', 'Title')))));
                } 

                ?>


               <?php echo "<div class='item-title'><a class='permalink' alt='Link to individual item page.' href="
                            .exhibit_builder_exhibit_item_uri($item).">".metadata($item, array("Dublin Core", "Title"), 
                                array('snippet'=>100))."</a></div>"; ?>
            </li>

        <?php endforeach; ?>

    </ul>
</div>

