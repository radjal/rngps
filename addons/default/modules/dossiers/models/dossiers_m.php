<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dossiers_m extends MY_Model {
 	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'dossiers';
    }       
        
        
        public function dossiers_par_rngps($rngps=false)
        {
            if($rngps===false) $return;
            $dossier = $this->db->where('rngps', $rngps)
                            ->get('dossiers_docteurs')
                            ->result_array();  
            return $dossier ; 
        }
        
        
        public function dossiers_par_onameg($onameg=false)
        {
            if($onameg===false) $return;
            $dossier = $this->db->where('ancien_no', $onameg)
                            ->get('dossiers_docteurs')
                            ->result_array();  
            return $dossier ; 
        }
        
        
        public function get_dossiers($doc_id=false)
        {
            if($doc_id===false) $return;
            $res = $this->db->where('id', $doc_id)
                            ->get('dossiers_docteurs')
                            ->result_array();  
            return $res[0];
        }
        
        public function form_checkbox_days($selected, $extra='class="width-15"')
        {
                $html  =form_checkbox('days', 'weekday_1', $selected == 'weekday_1', $extra); 
                $html .=lang('dossiers:weekday_1');
                    $html .=form_checkbox('days', 'weekday_2', $selected == 'weekday_1', $extra); 
                    $html .=lang('dossiers:weekday_1');
                        $html .=form_checkbox('days', 'weekday_3', $selected == 'weekday_1', $extra); 
                        $html .=lang('dossiers:weekday_1');
                            $html .=form_checkbox('days', 'weekday_4', $selected == 'weekday_1', $extra); 
                            $html .=lang('dossiers:weekday_1');
                            $html .='test';
                return $html ;
        }
        
        	// get file
	public function getfile($filepath, $output=false)
	{
		$output = strtolower($output);
		$path = ADDONPATH."modules/dossiers/$filepath";
		
		if(!empty($path)) $content = file_get_contents($path); 
		
		switch($output) {
			case 'json':
				$content = json_encode($content);
				break;
			case 'oneline':
				$order   = array("\r\n", "\n", "\r");
				$content = str_replace($order, ' ', $content);
				$content = str_replace("'", "\'", $content);
				break;
			default :
				break;
		}
		return $content;
	}
        

}