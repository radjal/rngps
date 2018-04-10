<?php defined('BASEPATH') or exit('No direct script access allowed');

/** copied from 
 * PyroStreams Text Field Type 
 * radja...
 *
 * @package		Custom
 * @author		Radja Lomas 
 */
class Field_date
{
	public $field_type_slug			= 'date';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Radja Lomas', 'url'=>'http://radja.fr');
	
	public $custom_parameters		= array('max_length', 'default_value');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		$options['type']	= 'date' ;
		
		if (isset($data['max_length']) and is_numeric($data['max_length']))
		{
			$options['maxlength'] = $data['max_length'];
		}
		
                //array('name' => 'appointmentDelete', 'type' => 'submit')
		return form_input($options);
	}
 
}