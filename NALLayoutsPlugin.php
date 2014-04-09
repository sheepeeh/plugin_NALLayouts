<?php
class NALLayoutsPlugin extends Omeka_Plugin_AbstractPlugin
{

public function hookInitialize()
{
    get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'ExhibitFormAttachmentsNAL');

    get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'ExhibitAttachmentGalleryNAL');
}

    protected $_filters = array('exhibit_layouts');

    public function filterExhibitLayouts($layouts)
    {
        $layouts['nal-titlebar'] = array(
            'name' => 'NAL Titlebar',
            'description' => 'A list layout with titlebars.'
        );
        return $layouts;
    }
}