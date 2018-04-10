<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a verification module for PyroCMS
 *
 * @author 		Radja LOMAS radjal@free.fr
 * @website		http://radja.fr
 * @package 	PyroCMS
 * @subpackage 	verification Module
 */
class Plugin_Verification extends Plugin
{        

	/**
	 * JS as JSON string
	 * Usage:
	 * 
	 * {{ verification:js encode='oneline' }} json or oneline(escaped)
	 *
	 * @return	array
	 */
	function js()
	{
		        
                $encode = strtolower($this->attribute('encode'));
		
		return $this->verification_m->getfile('js/verification.js', $encode);
	}
        
	/**
	 * CSS as JSON string
	 * Usage:
	 * 
	 * {{ verification:css encode='oneline' }} json or oneline(escaped)
	 *
	 * @return	array
	 */
	function css()
	{        
                $encode = strtolower($this->attribute('encode'));
		
		return $this->verification_m->getfile('css/verification.css', $encode);
	}
        
	function verificationlist()
	{      
			$html = '';
            $html .= '<script type="text/javascript">' ;
            $html .= $this->verification_m->getfile("js/verifications.js" );

            $html .= '</script>' ;
            return $html;   
	}

}

/* End of file plugin.php */