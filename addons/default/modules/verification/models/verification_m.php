<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Verification_m extends MY_Model {
    
 	public function __construct()
	{		
		parent::__construct();
		
		//$this->_table = 'verifications';
	}        
        
	// get file
	public function getfile($filepath, $output=false)
	{
		$output = strtolower($output);
		$path = ADDONPATH."modules/verification/$filepath";
		
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