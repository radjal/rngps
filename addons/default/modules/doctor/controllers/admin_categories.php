<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Streams Sample Module
 *
 * This is a sample module for PyroCMS
 * that illustrates how to use the streams core API
 * for data management.
 *
 * @author 		Adam Fairholm - PyroCMS Dev Team
 * @website		http://pyrocms.com
 * @package 	PyroCMS
 * @subpackage 	Streams Sample Module
 */
class Admin_categories extends Admin_Controller
{
    // This will set the active section tab
    protected $section = 'categories';

    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('doctor');

        $this->load->driver('Streams');
    }

    /**
     * List all using Streams CP Driver
     *
     * In this alternate index, we are using the
     * Streams API driver to 
     *
     * @access	public
     * @return	void
     */
    public function index()
    {
        $extra['title'] = 'lang:doctor:categories';
        
        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/doctor/categories/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/doctor/categories/delete/-entry_id-',
                'confirm' => true
            )
        );
        
        //entries_table($stream_slug, $namespace_slug, $pagination = null, $pagination_uri = null, $view_override = false, $extra = array())
        $this->streams->cp->entries_table('categories', 'doctor', 20, 'admin/doctor/categories/index', true, $extra);
    }

    public function create()
    {
		$extra['title'] = 'lang:doctor:new';

        $extra = array(
            'return' => 'admin/doctor/categories/index',
            'success_message' => lang('doctor:submit_success'),
            'failure_message' => lang('doctor:submit_failure'),
            'title' => lang('doctor:categories:new')
        );

        $skips = array('cat_dom_id');
        $this->streams->cp->entry_form('categories', 'doctor', 'new', null, true, $extra, $skips);
    }

	
    public function edit($id = 0)
    {
        $this->template->title(lang('doctor:edit'));

        $extra = array(
            'return' => 'admin/doctor/categories/index',
            'success_message' => lang('doctor:submit_success'),
            'failure_message' => lang('doctor:submit_failure'),
            'title' => lang('doctor:edit')
        );

        $skips = array('cat_dom_id');
        $this->streams->cp->entry_form('categories', 'doctor', 'edit', $id, true, $extra, $skips);
    }

    // --------------------------------------------------------------------------

	
    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, 'categories', 'doctor');
        $this->session->set_flashdata('error', lang('doctor:deleted'));
        redirect('admin/doctor/categories/index');
    }

}