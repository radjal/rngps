<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a dossiers module for PyroCMS
 *
 * @author 		Radja LOMAS radjal@free.fr
 * @website		http://radja.fr
 * @package 	PyroCMS
 * @subpackage 	dossiers Module
 */
class Plugin_Doctor extends Plugin
{        

	/**
	 * JS as JSON string
	 * Usage:
	 * 
	 * {{ dossiers:js encode='oneline' }} json or oneline(escaped)
	 *
	 * @return	string
	 */
	function js()
	{
		$this->load->model('dossiers_m');
		//$this->lang->load('dossiers');
                
                $encode = strtolower($this->attribute('encode'));
		
		return $this->dossiers_m->getfile('js/dossiers.js', $encode);
	}
        
	/**
	 * CSS as JSON string
	 * Usage:
	 * json or oneline(escaped)
	 * {{ dossiers:css encode='oneline' }} 
	 *
	 * @return	string
	 */
	function css()
	{
		$this->load->model('dossiers_m');
		//$this->lang->load('dossiers');
                
                $encode = strtolower($this->attribute('encode'));
		
		return $this->dossiers_m->getfile('css/dossiers.css', $encode);
	}
        
        /**
         * HTML script tag for dossiers.js 
         * 
         * {{ dossiers:dossierslist }} 
         * 
         * @return string
         */
//        function dossierslist()
//	{           
//            $this->load->model('dossiers/dossiers_m');
//            $html = '';
//            $html .= '<script type="text/javascript">' ;
//            $html .= $this->dossiers_m->getfile("js/dossiers.js" );
//            $html .= '</script>' ;
//            return $html;   
//	}

        /**
         * HTML search form 
         * 
         * {{ dossiers:search_box }} 
         * 
         * @return string
         */
        function search_box() 
        {
            $search = $this->input->get('s');
            $cat = $this->input->get('c'); 
            
            $html = '<div id="dossiers-search" class="">';
                $html .= '<form method="get" action="'.  site_url().'dossiers">' ;
                    $html .= '<div class="form-group searchbox-query">';
                        $html .= '<div class="input-group">';
                            $html .= '<span class="input-group-addon"><a class="" onclick="cleanDocSearch()"><i class="glyphicon glyphicon-remove-circle"></i></a></span>';  
                            $html .= form_input('c', $cat, 'placeholder="Domaine ou spécialité médicale"'.' class="form-control"') ;
                        $html .= '</div> ';
                    $html .= '</div> <div class="form-group searchbox-area">';
                        $html .= '<div class="input-group">';
                            $html .= '<span class="input-group-addon"><a class="" onclick="geoGetTown()"><i class="glyphicon glyphicon-map-marker"></i></a></span>';  
                            $html .= form_input('s', $search, 'placeholder="Ville, quartier ou CP"'.' class="form-control"') ; 
                            $html .= '<span class="input-group-btn">'; 
                                $html .= form_button(array('name' => 'submitBtn', 'type'=>'submit'),'<i class="glyphicon glyphicon-search"></i>', ' class="btn btn-primary"') ;
                            $html .= '</span>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</form>';
            $html .= '</div>'; 
                
                if(!empty($search) or !empty($cat)) { $html .= '<br />'.anchor(site_url().'dossiers','Recharger'); }
                
//                $html .= '<script> console.log("test") ; $( document ).ready(function(){ ';
//                $html .= "if(navigator.geolocation !== true) { $('#dossiers-search .input-group-addon a').addClass('disabled'); ";
//                $html .=  "} else { $('#dossiers-search .input-group-addon a').on('click', geoGetTown); console.log('geobtn') ;} ";
//                $html .= ' });</script>';
                
            $html .= '</div></form></div>' ;
            return $html;   
        } 
          	
        /**
	 * dossiers list
         * 
	 * {{ dossiers:listing limit="5" order_by="id" order="asc" zone_id="2" area_name="area_name" town="town" }}
	 *      {{ id }} {{ name }} {{ area_name }} {{ town }}
	 * {{ /dossiers:listing }}
	 *
	 * @return	array
	 */
	function listing()
	{
                $limit = $this->attribute('limit');
                $order = !empty($this->attribute('order')) ? $this->attribute('order') : 'asc';
                $order_by = !empty($this->attribute('order_by')) ? $this->attribute('order_by') : 'name';
                $zone_id = $this->attribute('dossiers_zone');
		$town = $this->attribute('town');
		$area_name = $this->attribute('area_name');
		
            // query setting
                if(!empty($zone_id)) $this->db->where("zone_id",$zone_id);
                if(!empty($town)) $this->db->or_like("town", $town);
                if(!empty($area_name)) $this->db->or_like("area_name", $area_name);
                $this->db->order_by($order_by, $order);


		$data = $this->db->limit($limit)
                                    ->get('dossiers_dossiers')
                                    ->result_array();

                // add numbering
                foreach ($data as $key => $value) {
                        $data[$key]['count'] = $key+1; 
                    }

                return $data;
	}
          	
        /**
	 * show dossiers
         * 
	 * {{ dossiers:show id="10" }}
	 *      {{ id }} {{ name }} {{ area_name }} {{ town }}
	 * {{ /dossiers:show }}
	 *
	 * @return	array or false
	 */
	function show()
	{
                $limit = 1;  
                $id = $this->attribute('id');
                if(empty($id)) return false;
                //@todo user role checks
//                $user_id
//                $dossiers_id
                $this->db->select('dossiers_dossiers.*');
                $this->db->select('dossiers_categories.*');
                $this->db->select('dossiers_organisations.*');
                $this->db->select('files.filename AS img_path');
            // query setting
                if(!empty($id)) 
                {
                    $this->db->where("dossiers_dossiers.id ",$id); 
                } else {
                    return false;
                }
                $this->db->join('dossiers_categories', 'dossiers_categories.id = dossiers_dossiers.dossiers_cat', 'left');
                $this->db->join('dossiers_organisations', 'dossiers_dossiers.groupe = dossiers_organisations.id', 'left');
                $this->db->join('files', 'dossiers_dossiers.image = files.id', 'left');
		$data = $this->db->limit($limit)
                                    ->get('dossiers_dossiers')
                                    ->result_array(); 

                return $data;
	}
 
}

/* End of file plugin.php */