<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Doctor extends Module
{
    public $version = '0.1.10';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Doctors',
                'fr' => 'Docteurs',
            ),
            'description' => array(
                'en' => 'Doctors list',
                'fr' => 'Liste des Docteurs',
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
			'roles' => array(
				'edit', 'delete', 'create', 'set_location'
			),
            'sections' => array(
                'doctor' => array(
                    'name' => 'doctor:doctors',
                    'uri' => 'admin/doctor',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'doctor:new',
                            'uri' => 'admin/doctor/create',
                            'class' => 'add'
                        )
                    )
                ),
                'categories' => array(
                    'name' => 'doctor:categories',
                    'uri' => 'admin/doctor/categories/index',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'doctor:category:new',
                            'uri' => 'admin/doctor/categories/create',
                            'class' => 'add'
                        )
                    )
                ),
                'organisations' => array(
                    'name' => 'doctor:organisations',
                    'uri' => 'admin/doctor/organisations/index',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'doctor:organisation:new',
                            'uri' => 'admin/doctor/organisations/create',
                            'class' => 'add'
                        )
                    )
                )
            )
        );
    }

    /**
     * Install
     *
     * This function will set up our
     * FAQ/Category streams.
     */
    public function install()
    {
        //db forge drop
//        $this->dbforge->drop_table('doctors');
//        $this->dbforge->drop_table('doctors_categories');
//        $this->dbforge->drop_table('doctors_organisations');
        $this->db->delete('settings', array('module' => 'doctor'));
        // We're using the streams API to
        // do data setup.
        $this->load->driver('Streams'); 
        //just in case, remove streams first
        $this->streams->utilities->remove_namespace('doctor'); 
        // Add doctors streams
        if ( ! $this->streams->streams->add_stream('lang:doctor:doctors', 'doctors', 'doctor', 'doctor_', null)) return false;
        if ( ! $categories_stream_id = $this->streams->streams->add_stream('lang:doctor:categories', 'categories', 'doctor', 'doctor_', null)) return false;
        if ( ! $organisations_stream_id = $this->streams->streams->add_stream('lang:doctor:organisations', 'organisations', 'doctor', 'doctor_', null)) return false;
 
        // Create image folder
        $this->load->library('files/files');
        $imgfolder = Files::create_folder(0, 'Doctors module');
        
        // Add some fields
        if(1)
        {
                    $fields = array(
                        //doctors
                        array(
                            'name' => 'Nom du practicien',
                            'slug' => 'name',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'extra' => array('max_length' => 200),
                            'assign' => 'doctors',
                            'required' => false 
                        ), 
                        array(
                            'name' => 'Jours ouverts',
                            'slug' => 'days',
                            'namespace' => 'doctor',
                            'type' => 'choice',
                            'extra' => array('choice_data' => "1 : lundi
                                        2 : mardi
                                        3 : mercredi
                                        4 : jeudi
                                        5 : vendredi
                                        6 : samedi
                                        0 : dimanche", 
                                        'choice_type' => 'checkboxes', 
                                        'default_value' => ''),
                            'assign' => 'doctors',
                            'required' => false,
                            'unique' => false
                        ),
                        array(
                            'name' => 'Heures d\'ouverture',
                            'slug' => 'hours',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'extra' => array('max_length' => 200),
                            'assign' => 'doctors',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Ouverture',
                            'slug' => 'opens',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'extra' => array('max_length' => 10),
                            'assign' => 'doctors',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Fermeture',
                            'slug' => 'closes',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'extra' => array('max_length' => 10),
                            'assign' => 'doctors',
                            'required' => false 
                        ),
                        array(
                            'name' => 'RDV Max Jour(30")',
                            'slug' => 'max_per_day',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'extra' => array('max_length' => 2),
                            'assign' => 'doctors',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Description',
                            'slug' => 'description',
                            'namespace' => 'doctor',
                            'type' => 'textarea',
                            'assign' => 'doctors',
                            'required' => false
                        ),
                        array(
                            'name' => 'Téléphone',
                            'slug' => 'telephone',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => false
                        ),
                        array(
                            'name' => 'Mobile',
                            'slug' => 'mobile',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => false
                        ),
                        array(
                            'name' => 'Email',
                            'slug' => 'email',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => false
                        ),
                        array(
                            'name' => 'Adresse',
                            'slug' => 'address',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => true
                        ),
                        array(
                            'name' => 'Quartier',
                            'slug' => 'area_name',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => true
                        ),
                        array(
                            'name' => 'Ville',
                            'slug' => 'town',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'doctors',
                            'required' => true
                        ),
                        array(
                            'name' => 'Image docteur',
                            'slug' => 'image',
                            'namespace' => 'doctor',
                            'type' => 'image',
                             'extra' => array('folder' => $imgfolder['data']['id'], 'required' => FALSE), // use id of folder created with core files modules
                            'assign' => 'doctors',
                            'required' => false
                        ),
                        //category link
                        array(
                            'name' => 'Catégorie',
                            'slug' => 'doctor_cat',
                            'namespace' => 'doctor',
                            'type' => 'relationship',
                            'assign' => 'doctors',
                            'extra' => array('choose_stream' => $categories_stream_id)
                        ),
                        //categories
                        array(
                            'name' => 'Spécialité médicale',
                            'slug' => 'speciality',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'categories',
                            'title_column' => true,
                            'required' => true,
                            'unique' => true
                        ),
//                        array(
//                            'name' => 'Domain id',
//                            'slug' => 'domain_id',
//                            'namespace' => 'doctor',
//                            'type' => 'text',
//                            'assign' => 'categories',
//                            'required' => false,
//                            'hidden' => true
//                        ),
                        array(
                            'name' => 'Catégorie parente',
                            'slug' => 'parent_cat',
                            'namespace' => 'doctor',
                            'type' => 'relationship',
                            'assign' => 'categories',
                            'extra' => array('choose_stream' => $categories_stream_id),
                            'required' => false
                        ),
                        //organisation link
                        array(
                            'name' => 'Organisme ou groupe',
                            'slug' => 'groupe',
                            'namespace' => 'doctor',
                            'type' => 'relationship',
                            'assign' => 'doctors',
                            'extra' => array('choose_stream' => $organisations_stream_id)
                        ),
                        //organisations 
                        array(
                            'name' => 'Structure',
                            'slug' => 'organisation',
                            'namespace' => 'doctor',
                            'type' => 'relationship',
                            'assign' => 'organisations',
                            'extra' => array('choose_stream' => $organisations_stream_id)
                        ),
                        array(
                            'name' => 'Etablissement',
                            'slug' => 'subset',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'organisations',
                            'title_column' => true,
                            'required' => true,
                            'unique' => true
                        ),            
                    );
        }

        //update
        $this->streams->fields->add_fields($fields);
        //admin views
        $this->streams->streams->update_stream('doctors', 'doctor', array(
            'view_options' => array(
//                'id',
                'days',
                'description',
                'groupe',
                'doctor_cat'
            )
        )); 
        $this->streams->streams->update_stream('categories', 'doctor', array(
            'view_options' => array(
//                'id',
                'parent_cat',
                'speciality',
            )
        ));
        $this->streams->streams->update_stream('organisations', 'doctor', array(
            'view_options' => array(
//                'id',
                'organisation', 
                'subset', 
            )
        ));

        return true;
    }

    /**
     * Uninstall
     *
     * Uninstall our module - this should tear down
     * all information associated with it.
     */
    public function uninstall()
    {
        $this->load->driver('Streams');

        // For this teardown we are using the simple remove_namespace
        // utility in the Streams API Utilties driver.
        $this->streams->utilities->remove_namespace('doctor');

        return true;
    }

    public function upgrade($old_version)
    {
        $this->load->driver('Streams');
        
        if(version_compare($this->version, '0.0.01', '<=') ) 
        {   //DB forge method
                $table = array(
                        'parent' => array( 'type' => 'VARCHAR', 'constraint' => '255', 'unique' => false, 'null' => TRUE),
                        );

                 if( !$this->dbforge->add_column('doctor_categories', $table) ) return false;
        }
        if(version_compare($this->version, '0.0.05', '<=') ) 
        { //DB forge method
            $this->dbforge->drop_column('doctor_categories', 'parent');
            return true;
        }
        if(version_compare($this->version, '0.0.06', '<=') ) 
        {  //Streams method
                $categories_stream_id = $this->streams->streams->get_stream('categories', 'doctor' );
                $fields = array(
                        array(
                            'name' => 'Catégorie parente',
                            'slug' => 'parent',
                            'namespace' => 'doctor',
                            'type' => 'text',
                            'assign' => 'categories',
                            'required' => false
                        ),
                );
        
                $this->streams->fields->add_fields($fields);
        }
        if(version_compare($this->version, '0.0.09', '<=') ) 
        { 
            //DB forge method           
                $data = array(
                   'field_name' => 'Quartier'
                ); 
                $this->db->where('field_slug', 'area_name'); // value
                $this->db->update('data_fields', $data);  // table 
        } 
        if(version_compare($this->version, '0.0.91', '<=') ) 
        {  
            //new stream for organisations
            if ( ! $organisations_stream_id = $this->streams->streams->add_stream('lang:doctor:organisations', 'organisations', 'doctor', 'doctor_', null)) return false; 
            //organisations
            $fields = array(
                            array(
                                'name' => 'Organismes',
                                'slug' => 'organisation',
                                'namespace' => 'doctor',
                                'type' => 'relationship',
                                'assign' => 'organisations',
                                'extra' => array('choose_stream' => $organisations_stream_id)
                            ),
                            array(
                                'name' => 'Nom organisme',
                                'slug' => 'subset',
                                'namespace' => 'doctor',
                                'type' => 'text',
                                'assign' => 'organisations',
                                'title_column' => true,
                                'required' => true,
                                'unique' => true
                            )); 
            //update
            $this->streams->fields->add_fields($fields);
            //admin views
            $this->streams->streams->update_stream('organisations', 'doctor', array(
                'view_options' => array(
                    'id',
                    'organisation', 
                )
            ));
        }
        if(version_compare($this->version, '0.0.92', '<=') ) 
        {
            $this->streams->streams->update_stream('categories', 'doctor', array(
                'view_options' => array(
                    'id',
                    'parent',
                    'speciality',
                )
            ));
            $this->streams->streams->update_stream('organisations', 'doctor', array(
                'view_options' => array(
                    'id',
                    'subset', 
                )
            )); 
        }
        return true;
    }

    public function help()
    {
        // Return a string containing help info
        // You could include a file and return it here.
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}