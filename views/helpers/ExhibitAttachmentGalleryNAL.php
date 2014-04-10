<?php

/**
* Exhibit gallery view helper.
*
* @package ExhibitBuilder\View\Helper
*/
class NALLayouts_View_Helper_ExhibitAttachmentGalleryNAL extends Zend_View_Helper_Abstract
{
    /**
* Return the markup for a gallery of exhibit attachments.
*
* @uses ExhibitBuilder_View_Helper_ExhibitAttachment
* @param ExhibitBlockAttachment[] $attachments
* @param array $fileOptions
* @param array $linkProps
* @return string
*/
    public function exhibitAttachmentGalleryNAL($attachments, $fileOptions = array(), $linkProps = array())
    {
        if (!isset($fileOptions['imageSize'])) {
            $fileOptions['imageSize'] = 'square_thumbnail';
        }
        
        $html = '';
        foreach ($attachments as $attachment) {
            $item = $attachment->getItem();
            $html .= '<div class="exhibit-item exhibit-gallery-item">';
            $html .= '<div class="gallery-item-title">';
            $html .= metadata($item, array("Dublin Core", "Title"), array('snippet'=>100));


            if (metadata($item, array("Dublin Core", "Date"))) { $html .= '<span class="exhibit-item-date"> (' . metadata($item, array("Dublin Core", "Date")) . ')</span>'; }
            

            $html .= '</div>';
            $html .= $this->view->exhibitAttachment($attachment, $fileOptions, $linkProps, true);
            $html .= '</div>';
        }
    
        return apply_filters('exhibit_attachment_gallery_markup', $html,
            compact('attachments', 'fileOptions', 'linkProps'));
    }
}