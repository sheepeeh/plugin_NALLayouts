<?php
class NALLayoutsPlugin extends Omeka_Plugin_AbstractPlugin
{

    protected $_filters = array('exhibit_layouts');

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

    // public function hookInitialize()
    // {
    //     get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'NALLayouts_View_Helper_');
    // }

    // public function hookDefineAcl($args)
    // {
    //     $acl = $args['acl'];
    //     $exhibitItems = new Zend_Acl_Resource('NALLayouts_ExhibitsNAL');
    //     $acl->add($exhibitItems);        
    // }

    public function hookAdminExhibitPagePanelFields() {
        ?>
        <div class="field">
            <div class="two columns alpha">
                <?php echo $this->formLabel('tags', __('Tags')); ?>
            </div>
            <div class="five columns omega inputs">
                <?php $exhibitPageTagList = join(', ', pluck('name', $exhibit_page->Tags)); ?>
                <?php echo $this->formText('tags', $exhibitPageTagList); ?>
            </div>
        <?php
    }

}