<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Based on FAQ Module example - radja
 *
 * This is a sample module for PyroCMS
 * that illustrates how to use the streams core API
 * for data management. It is also a fully-functional
 * FAQ module so feel free to use it on your sites.
 *
 * Most of these functions use the Streams API CP driver which
 * is designed to handle repetitive CP tasks, down to even loading the page.
 *
 * @author 		Adam Fairholm - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Streams Sample Module
 */
class Admin extends Admin_Controller
{
    // This will set the active section tab
    protected $section = 'doctor';

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('doctor');
        $this->load->driver('Streams');
        
        $this->template->append_css('module::admin.css');
    }

    /**
     * List all enrties using Streams CP Driver
     *
     * We are using the Streams API to grab
     * data from the doctors database. It handles
     * pagination as well.
     *
     * @return	void
     */
    public function index()
    {
        // The extra array is where most of our
        // customization options go.
        $extra = array();

        // The title can be a string, or a language
        // string, prefixed by lang:
        $extra['title'] = 'lang:doctor:doctors';
        
        // We can customize the buttons that appear
        // for each row. They point to our own functions
        // elsewhere in this controller. -entry_id- will
        // be replaced by the entry id of the row.
        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/doctor/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/doctor/delete/-entry_id-',
                'confirm' => true
            )
        );
        
        // customizing headers
        $extra['columns'] = array('id', 'doctor_cat', 'groupe', 'name', 'days', 'opens', 'closes', 'address', 'area_name', 'town',);
        
        $this->streams->cp->entries_table('doctors', 'doctor', 20, null, true, $extra);
    }

    /**
     * List all entries (Alternate)
     *
     * This example is similar to index(), but we are
     * getting entries manually using the entries API
     * and displaying the output in a custom view file.
     *
     * @return  void
     */
    public function index_alt()
    {
        // Get our entries. We are simply specifying
        // the stream/namespace, and then setting the pagination up.
        $params = array(
            'stream' => 'doctors',
            'namespace' => 'doctor',
            'paginate' => 'yes',
            'limit' => 4,
            'pag_segment' => 4
        );
        $data['doctors'] = $this->streams->entries->get_entries($params);

        // Build the page. See views/admin/index.php
        // for the view code.
        $this->template
                    ->title($this->module_details['name'])
                    ->build('admin/index', $data);
    }

    /**
     * Create a new entry
     *
     * We're using the entry_form function
     * to generate the form.
     *
     * @return	void
     */
    public function create()
    {
        $extra = array(
            'return' => 'admin/doctor',
            'success_message' => lang('doctor:submit_success'),
            'failure_message' => lang('doctor:submit_failure'),
            'title' => lang('lang:doctor:new'),
         );
        
        $skips = array('dom_id');
        //entry_form($stream_slug, $namespace_slug, $mode = 'new', $entry_id = null, $view_override = false, $extra = array(), $skips = array(), $tabs = false, $hidden = array(), $defaults = array())
        $this->streams->cp->entry_form('doctors', 'doctor', 'new', null, true, $extra, $skips);
    }
    
    /**
     * Edit an entry
     *
     * We're using the entry_form function
     * to generate the edit form. We're passing the
     * id of the entry, which will allow entry_form to
     * repopulate the data from the database.
     *
     * @param   int [$id] The id of the FAQ to the be deleted.
     * @return	void
     */
    public function edit($id = 0)
    {
        $this->load->model('doctor_m');
        $extra = array(
            'return' => 'admin/doctor',
            'success_message' => lang('doctor:submit_success'),
            'failure_message' => lang('doctor:submit_failure'),
            'title' => 'lang:doctor:edit'
        );

        $skips = array('dom_id');
         $this->streams->cp->entry_form('doctors', 'doctor', 'edit', $id, true, $extra, $skips);
//        $this->streams->cp->entry_form('doctors', 'doctor', 'edit', $id, true, $extra);
        
        // Build the page 
//        $this->template
//                    ->title($this->module_details['name'])
//                    ->build('admin/form' );
        
    }

    /**
     * Delete an entry
     * 
     * @param   int [$id] The id of FAQ to be deleted
     * @return  void
     */
    public function delete($id = 0)
    {
        $this->streams->entries->delete_entry($id, 'doctors', 'doctor');
        $this->session->set_flashdata('error', lang('doctor:deleted'));
 
        redirect('admin/doctor/');
    }
    
    /** returns AJAX list of user IDs for name query
     * 
     * @param type $query
     */
    public function user_search($query) 
    {
        
    }

}