<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//$route['verification/admin/categories(:any)'] = 'admin_categories$1'; 

$route['verification(/:any)?']			= 'verification/index$1';