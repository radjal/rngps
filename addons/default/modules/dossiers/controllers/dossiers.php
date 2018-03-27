<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dossiers extends Public_Controller
{

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dossiers_m');
        $this->lang->load('dossiers');
        $this->load->driver('Streams');
        $this->template->append_css('module::dossiers.css');
        $this->template->append_js('module::dossiers.js');
    }
	
     /**
     * List all Doctors
     *
     * We are using the Streams API to grab
     * data from the dossiers database. It handles
     * pagination as well.
     *
     * @access	public
     * @return	void
     */
    public function index()
    {        
        $params = array(
            'stream' => 'dossiers',
            'namespace' => 'dossiers',
            'paginate' => 'yes'
        );
        
        $category = $this->input->get('c'); 
        $this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('dossiers_categories', true).' ON '.$this->db->protect_identifiers('dossiers_categories.id', true).' = '.$this->db->protect_identifiers('dossiers_dossiers.dossiers_cat', true);
        $this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('dossiers_organisations', true).' ON '.$this->db->protect_identifiers('dossiers_organisations.id', true).' = '.$this->db->protect_identifiers('dossiers_dossiers.groupe', true);

        $search = $this->input->get('s');
        if(!empty($search) and !empty($category))   
        { 
            $params['where'] = "default_dossiers_categories.speciality LIKE '%$category%' AND ( default_dossiers_dossiers.town LIKE '%$search%' OR default_dossiers_dossiers.area_name LIKE '$search%')" ;
        } 
        else if(!empty($search)) 
        {
            $params['where'] = "default_dossiers_dossiers.town LIKE '%$search%' OR default_dossiers_dossiers.area_name LIKE '$search%'" ;
        }
        else if(!empty($category)) 
        {
            $params['where'] = "default_dossiers_categories.speciality LIKE '%$category%' " ;
        }
        
        $data = new stdClass();
        $data->dossiers = $this->streams->entries->get_entries($params);
        

        $template = 'dossiers';
 				
        // AJAX and XHR
        if($this->input->is_ajax_request() AND $this->template->set_layout(false))
        {
            $adata = $data->dossiers;
            foreach ($adata['entries'] as $key => $value) 
            {
                $adata['entries'][$key]['js_name'] = json_encode($adata['entries'][$key]['name']) ;
                $adata['entries'][$key]['js_town'] = json_encode($adata['entries'][$key]['town']) ;
                $adata['entries'][$key]['js_description'] = json_encode($adata['entries'][$key]['description']) ;
                $adata['entries'][$key]['js_address'] = json_encode($adata['entries'][$key]['address']) ;
                $adata['entries'][$key]['js_area_name'] = json_encode($adata['entries'][$key]['area_name']) ;
////                $adata['entries'][$key]['js_hours'] = json_encode($adata['entries'][$key]['hours']) ;
////                $adata['entries'][$key]['dossiers_zone']['js_dossiers_zone_title'] = json_encode($adata['entries'][$key]['dossiers_zone']['dossiers_zone_title']) ;
            }
//            $data = json_encode($data);
            $template = 'ajax';
            $data->dossiers = $adata;
        } 
        
        // Build the page
            $this->template->title(lang('dossiers:dossiers'))
//                ->set('jsdata', $data)
                ->set('search', $search)
//                ->set('doc_count', $dcount)
                ->set('category', $category)
//                ->set('cal_week', $cal_week)
                ->build($template, $data);
    }
	
     /**
     * show dossiers
     *
     * We are using the Streams API to grab
     * data from the dossiers database. It handles
     * pagination as well.
     *
     * @access	public
     * @return	void
     */
    public function view($id)
    {
        
        $this->load->model('dossiers_m');
        $params = array(
            'stream' => 'dossiers',
            'namespace' => 'dossiers',
            'paginate' => 'no'
        );
         
        $this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('dossiers_categories', true).' ON '.$this->db->protect_identifiers('dossiers_categories.id', true).' = '.$this->db->protect_identifiers('dossiers_dossiers.dossiers_cat', true);
        $this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('dossiers_organisations', true).' ON '.$this->db->protect_identifiers('dossiers_organisations.id', true).' = '.$this->db->protect_identifiers('dossiers_dossiers.groupe', true);
 
        $params['where'] = "default_dossiers_dossiers.id = '$id' " ;
  
        $data = new stdClass();
        $data = $this->streams->entries->get_entries($params);
//        $data->dossiers = $this->streams->entries->get_entry($id, $params['stream'], $params['namespace'] );
        $dossiers = $data['entries'][0];
        
        //open days as string for template usage   
        $str='';
        foreach ($dossiers['days'] as $day ) 
        { 
                $str .= $day["value"] . ","; 
        }
        $str = trim($str, ',');//removes the final comma 
        $dossiers['daysopenstr']=$str; //FINISH
        
        //calendar
        
        $week_id = !empty($this->uri->segment(4)) ? $this->uri->segment(4) : false; 
        $this->load->model('appointments/appointments_m');
        $this->load->model('calendar/calendar_m');
        // day periods calculation
        $day_periods = $this->calendar_m->periods_make_day();    
        $cal_week =  $this->calendar_m->calculate_week($week_id);

        //LOOP dossiers 
        $weekArr = explode(',', 'lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche'); 
        $jours_ouverts= implode(',',$weekArr);  
//        $dcount = 0;
//        foreach ($data->dossiers['entries'] as $dossiers) 
//        {
            // calculate whole week of days
            for($wc = 1; $wc < 8; $wc++) 
            { 
                    $dn = $weekArr[$wc-1]; //day names
                    if(strstr($jours_ouverts, $dn )) //if open on day
                    { 
                        // get appointments for day
                        $datestr = str_replace('-', '', $cal_week['week_dates_iso'][$wc]['date']); 
                        $dossiers['appointments'][$dn] = $this->appointments_m->get_for_date($datestr, $dossiers['id']);   
                        $dossiers['calendar'][$dn] = $this->calendar_m->periods_splice_arrays( $day_periods, $dossiers['appointments'][$dn] ) ;  
                    }
            }
            //update dossiers array
            $dossiers = $dossiers; //reassign
//            $dcount++; 
//        }   
        
        
        
        $template = 'dossiers';
 				
        // AJAX and XHR
        if($this->input->is_ajax_request() AND $this->template->set_layout(false))
        {
//            $adata = $data->dossiers;
////            foreach ($adata['entries'] as $key => $value) 
////            {
////                $adata['entries'][$key]['js_name'] = json_encode($adata['entries'][$key]['name']) ;
////                $adata['entries'][$key]['js_town'] = json_encode($adata['entries'][$key]['town']) ;
////                $adata['entries'][$key]['js_description'] = json_encode($adata['entries'][$key]['description']) ;
////                $adata['entries'][$key]['js_address'] = json_encode($adata['entries'][$key]['address']) ;
////                $adata['entries'][$key]['js_area_name'] = json_encode($adata['entries'][$key]['area_name']) ;
////////                $adata['entries'][$key]['js_hours'] = json_encode($adata['entries'][$key]['hours']) ;
////////                $adata['entries'][$key]['dossiers_zone']['js_dossiers_zone_title'] = json_encode($adata['entries'][$key]['dossiers_zone']['dossiers_zone_title']) ;
////            }
////            $data = json_encode($data);
//            $template = 'ajax';
//            $data->dossiers = $adata;
        } 
        
        // Build the page
            $this->template->title(lang('dossiers:dossiers'))
//                ->set('jsdata', $data)
                ->set('cal_week', $cal_week)
                ->build($template, $dossiers);
    }

}

/* End of file dossiers.php */
