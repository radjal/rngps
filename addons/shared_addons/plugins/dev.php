<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 */
class Plugin_Dev extends Plugin
{
	public $version = '1.0.0';

	public $name = array(
		'en'	=> 'Dev pmllugin'
	);

	public $description = array(
		'en'	=> 'Some dev helpers'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'hello' => array(
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'A simple "Hello World!" example.'
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
	 * Hello
	 *
	 * Usage:
	 * {{ example:hello }}
	 *
	 * @return string
	 */
	function hello()
	{
		$name = $this->attribute('name', 'World');
		
		return 'Hello '.$name.'!';
	}
	/**
	 * empties page and âge type cache if on dev. env.
	 *
	 * Usage:
	 * {{ dev:empty_cache }}
	 *
	 * @return string
	 */
	function empty_cache()
	{
		
		// If we are on the development environment,
		// we should get rid of the cache. That ways we can just
		// make updates to the page type files and see the
		// results immediately.
		if (ENVIRONMENT == PYRO_DEVELOPMENT)
		{
			$this->pyrocache->delete_all('page_m');
			$this->pyrocache->delete_all('page_type_m');
		}
	}
}

/* End of file example.php */