<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Based on the custom Plugin
 *
 *
 * @author		Radja Lomas
 * @package		
 * @copyright	
 */
class Plugin_Custom extends Plugin
{
	public $version = '1.1.10';

	public $name = array(
		'en'	=> 'Custom'
	);

	public $description = array(
		'en'	=> 'Some custom helpers for general use.'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger custom
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'hello' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'General custom helpers'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'name' => array(// this is the name="World" attribute
						'type' => 'text',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like asc|desc|random.
						'default' => 'World',// this attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
				),
			),
		);
	
		return $info;
	}

	/**
	 * return GET variable
	 *
	 * Usage:
	 * {{ custom:get_value name="GET_name"}}
	 *
	 */
	function get_value()
	{ 
            $getname = $this->attribute('name'); 
            if(empty($getname)) {return false;}
            return $this->input->get($getname);
	}

	/**
	 * returns GET variable in hidden input field
	 *
	 * Usage:
	 * {{ custom:get_value_as_hidden_field name="GET_name"}}
	 *
	 */
	function get_value_as_hidden_field()
	{ 
            $getname = $this->attribute('name'); 
            if(isset($getname)===null) {return false;}
            return form_hidden($getname, $this->input->get($getname));
	}

	/**
	 * return POST variable
	 *
	 * Usage:
	 * {{ custom:get_value name="POST_name"}}
	 *
	 */
	function post_value()
	{ 
            $getname = $this->attribute('name'); 
            if(empty($getname)) {return false;}
            return $this->input->post($getname);
	}
        
	/**
	 * disables theme if page call is ajax pages modules templates
	 * 
	 * Usage:
	 * {{ custom:disable_theme_if_ajax }}
	 *
	 */
	function disable_theme_if_ajax()
	{
                if ($this->input->is_ajax_request() )
                {
                    $this->disable_theme();
                }       
	}
        
	/**
	 * calls language string and escapes for JS inclusion
	 *
	 * Usage:
	 * {{ custom:lang_line_for_js line="code:placeholder"}}
	 *
	 */
	function lang_line_for_js()
	{
            $line = $this->attribute('line');
            $res = lang($line);
            $res = addslashes($res); 
            return $res ;
	}
        
	/**
	 * disable theme 
	 *
	 * Usage:
	 * {{ custom:disable_theme }}
	 *
	 */
	function disable_theme()
	{
            $this->template->set_layout(false);    
	}
        
	/**
	 * checks if ajax call
	 *
	 * Usage:
	 * {{ custom:check_if_ajax }}
	 *
	 */
	function check_if_ajax()
	{
                if ($this->input->is_ajax_request() )
                {
                    return true;
                }       
                return false;
	}

        /**
	 * load a language file from shared_addons/language
	 * use full language name eg:'english' NOT 'en'
         * 
	 * Usage:
	 * {{ custom:load_lang_file file="english"}}
	 *
	 */
        function load_lang_file() {
            $file = $this->attribute('file', null);
            $this->lang->load($file.'');
        }
        
        /**
	 * return name of subdomain if applicable
	 *
	 * Usage:
	 * {{ custom:subdomain_value }}
	 *
	 */
	function subdomain_value()
	{		
		$parsed = parse_url(base_url());
		$domain = explode('.', $parsed['host']);
		$subdomain = '';
		
		if (count($domain) > 2 ) // if more than 2 then there is a subdomain
		{
			if ($domain[0] == 'www')
			$subdomain = $domain[1];                
			else
			$subdomain = $domain[0];              
		}
		return  $subdomain;                     
	}
        
        
        /**
	 * return name of base domain if in subdomain
	 *
	 * Usage:
	 * {{ custom:base_domain }}
	 *
	 */
	function base_domain()
	{		
		$parsed = parse_url(base_url());
		$domain = explode('.', $parsed['host']);
		$subdomain = '';
		if ($domain[0] == 'www') unset($domain[0]);  
		$basedomain = $domain[1].'.'.$domain[2];
                //$proto = $_SERVER['REQUEST_SCHEME']; // not reliable
                $proto = isset($_SERVER['HTTPS']) ? 'https' : 'http';
		return  $proto.'://'.$basedomain;                       
	}
        
        
	/**
	 * returns true if user agent language matches language parameter to check
	 *
	 * Usage:
	 * {{ custom:check_browser_lang lang="en"}}
	 *
	 */
	function check_browser_lang()
	{	
            $this->load->library('user_agent');
            $this->lang->load('code');
            $check = $this->attribute('lang');
            $lang = $this->agent->accept_lang('fr');
            if($lang == $check) return true; 
            else  return null ;
	}         
}

/* End of file custom_user.php */