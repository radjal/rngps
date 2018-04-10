<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verification extends Public_Controller
{
    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    
        header('Access-Control-Allow-Origin: *'); 
        
        $this->load->model('verification_m'); 
        $this->load->model('dossiers/dossiers_m'); 
         $this->template->append_js('module::verification.js');
         $this->template->append_css('module::verification.css');
    } 
    
    /**
     * @access	public
     * @return	void
     */
    public function index($casNo=false, $etape2=null)
    {
            $template = !empty($casNo) ? $casNo : 'index'; 
            $data['cas'] = $casNo; 
            $data['etape2'] = $etape2;  

            $data['norngps'] = $this->input->get('rngps');
            $data['onameg'] = $this->input->get('onameg');
            $data['birth_date'] = $this->input->get('birth_date'); 

            if ($casNo == 'cas1')
            {
                $data['dossier'] = $this->dossiers_m->dossiers_par_rngps($data['norngps']);                 
            } 
            elseif ($casNo == 'cas2')
            {
                $data['dossier'] = $this->dossiers_m->dossiers_par_onameg($data['onameg']);                   
            }
            
            /**
            // AJAX and XHR
            if($this->input->is_ajax_request() AND $this->template->set_layout(false))
            {}
             */
        
            // Build the page
            $this->template->title('verification ' . $casNo )
                ->set('d', $data['dossier'][0]) 
                ->build($template, $data);
    } 
     
     
}

/* End of file verification.php */
