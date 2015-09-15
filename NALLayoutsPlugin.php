<?php
class NALLayoutsPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array('exhibit_builder_page_head');
    protected $_filters = array('exhibit_layouts', 'exhibit_builder_link_to_exhibit_item','exhibit_builder_exhibit_item_uri');

    
    // With thanks to github user annamichelle https://github.com/annamichelle/LightboxGallery/blob/4c882ae72ae1764cc1f1aed61ef7fa79c9fc21df/LightboxGalleryPlugin.php

   public function hookExhibitBuilderPageHead($args) {
            if (array_key_exists('nal-imggal', $args['layouts'])) {
                queue_js_file('lightbox.min', 'javascripts/lightbox');
                queue_css_file('lightbox');
            }
    
    }

    public static function filterExhibitBuilderLinkToExhibitItem($html)
    {
        preg_match('/(href\=\")(.*?)(\")/', $html, $matches);
        $itemID = preg_replace('/(href\=\")(.*)([0-9]{3,})(\")/', '\3', $matches[0]);
        $item = get_record_by_id('Item', $itemID);
        $files = $item->getFile();

        $html = str_replace($matches[0], "href=\"" . file_display_url($files, 'fullsize') . '" data-lightbox="lightbox-gallery"', $html);
        return $html;
    }

    public static function filterExhibitBuilderExhibitItemUri($uri)
    {
        // $itemID = preg_replace('/(http:\/\/)(.*)([0-9]{3,})/', '\3', $uri);
        // $item = get_record_by_id('Item', $itemID);
        // $files = $item->getFile();
        $uri = "test"; //file_display_url($files, 'fullsize');
        echo $uri;
        return $uri;
    }

    public function filterExhibitLayouts($layouts)
    {
        $layouts['nal-titlebar'] = array(
            'name' => 'NAL Titlebar',
            'description' => 'A list layout with titlebars.'
        );
		
		$layouts['nal-imggal'] = array(
            'name' => 'NAL Image Galleries',
            'description' => 'For migrating old Drupal Galleries'
        );
    
        $layouts['nal-moviegal'] = array(
            'name' => 'NAL Movie Gallery',
            'description' => 'Display two moving images per row.'
        );

        $layouts['nal-sidebar'] = array(
            'name' => 'NAL Sidebar List',
            'description' => 'Display a list of items beneath the exhibit navigation.'
        );

        return $layouts;
    }

    public static function nal_exhibit_builder_render_exhibit_page ($exhibitPage = null)
{
    if ($exhibitPage === null) {
        $exhibitPage = get_current_record('exhibit_page');
    }
    
    $blocks = $exhibitPage->ExhibitPageBlocks;
    $rawAttachments = $exhibitPage->getAllAttachments();
    $attachments = array();
    foreach ($rawAttachments as $attachment) {
        $attachments[$attachment->block_id][] = $attachment;
    }
    foreach ($blocks as $index => $block) {
        $layout = $block->getLayout();
        if ($layout->id != "nal-sidebar") {

        echo '<div class="exhibit-block layout-' . html_escape($layout->id) . '">';
        echo get_view()->partial($layout->getViewPartial(), array(
            'index' => $index,
            'options' => $block->getOptions(),
            'text' => $block->text,
            'attachments' => array_key_exists($block->id, $attachments) ? $attachments[$block->id] : array()
        ));
        echo '</div>'; }
    }
}

    public static function nal_exhibit_builder_render_exhibit_sidebar ($exhibitPage = null)
{
    if ($exhibitPage === null) {
        $exhibitPage = get_current_record('exhibit_page');
    }
    
    $blocks = $exhibitPage->ExhibitPageBlocks;
    $rawAttachments = $exhibitPage->getAllAttachments();
    $attachments = array();
    foreach ($rawAttachments as $attachment) {
        $attachments[$attachment->block_id][] = $attachment;
    }
    foreach ($blocks as $index => $block) {
        $layout = $block->getLayout();
        if ($layout->id == "nal-sidebar"){
                
                echo get_view()->partial($layout->getViewPartial(), array(
                    'index' => $index,
                    'options' => $block->getOptions(),
                    'text' => $block->text,
                    'attachments' => array_key_exists($block->id, $attachments) ? $attachments[$block->id] : array()
                ));
        }
    }
}

// Test for mobile browser
// from https://github.com/nengineer/isMobile/blob/master/README.md

public function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


}