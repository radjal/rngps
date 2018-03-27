<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Dossiers extends Module
{
    public $version = '0.1.10';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Dossiers',
                'fr' => 'Dossiers',
            ),
            'description' => array(
                'en' => 'Dossiers list',
                'fr' => 'Liste des Dossiers',
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
			'roles' => array(
				'edit', 'delete', 'create', 'set_location'
			),
            'sections' => array(
                'dossiers' => array(
                    'name' => 'dossiers:dossiers',
                    'uri' => 'admin/dossiers',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'dossiers:new',
                            'uri' => 'admin/dossiers/create',
                            'class' => 'add'
                        )
                    )
                ),
                'categories' => array(
                    'name' => 'dossiers:categories',
                    'uri' => 'admin/dossiers/categories/index',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'dossiers:category:new',
                            'uri' => 'admin/dossiers/categories/create',
                            'class' => 'add'
                        )
                    )
                ),
                'organisations' => array(
                    'name' => 'dossiers:organisations',
                    'uri' => 'admin/dossiers/organisations/index',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'dossiers:organisation:new',
                            'uri' => 'admin/dossiers/organisations/create',
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
//        $this->dbforge->drop_table('dossiers');
//        $this->dbforge->drop_table('dossiers_categories');
//        $this->dbforge->drop_table('dossiers_organisations');
        $this->db->delete('settings', array('module' => 'dossiers'));
        // We're using the streams API to
        // do data setup.
        $this->load->driver('Streams'); 
        //just in case, remove streams first
        $this->streams->utilities->remove_namespace('dossiers'); 
        // Add dossiers streams
        if ( ! $this->streams->streams->add_stream('lang:dossiers:dossiers', 'dossiers', 'dossiers', 'dossiers_', null)) return false;
        if ( ! $categories_stream_id = $this->streams->streams->add_stream('lang:dossiers:categories', 'categories', 'dossiers', 'dossiers_', null)) return false;
        if ( ! $organisations_stream_id = $this->streams->streams->add_stream('lang:dossiers:organisations', 'organisations', 'dossiers', 'dossiers_', null)) return false;
 
        // Create image folder
        $this->load->library('files/files');
        $imgfolder = Files::create_folder(0, 'Dossiers module');
        
        // Add some fields
        if(1)
        {
                    $fields = array(
                        //dossiers
                        array(
                            'name' => 'Nom du practicien',
                            'slug' => 'name',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'extra' => array('max_length' => 200),
                            'assign' => 'dossiers',
                            'required' => false 
                        ), 
                        array(
                            'name' => 'Jours ouverts',
                            'slug' => 'days',
                            'namespace' => 'dossiers',
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
                            'assign' => 'dossiers',
                            'required' => false,
                            'unique' => false
                        ),
                        array(
                            'name' => 'Heures d\'ouverture',
                            'slug' => 'hours',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'extra' => array('max_length' => 200),
                            'assign' => 'dossiers',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Ouverture',
                            'slug' => 'opens',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'extra' => array('max_length' => 10),
                            'assign' => 'dossiers',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Fermeture',
                            'slug' => 'closes',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'extra' => array('max_length' => 10),
                            'assign' => 'dossiers',
                            'required' => false 
                        ),
                        array(
                            'name' => 'RDV Max Jour(30")',
                            'slug' => 'max_per_day',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'extra' => array('max_length' => 2),
                            'assign' => 'dossiers',
                            'required' => false 
                        ),
                        array(
                            'name' => 'Description',
                            'slug' => 'description',
                            'namespace' => 'dossiers',
                            'type' => 'textarea',
                            'assign' => 'dossiers',
                            'required' => false
                        ),
                        array(
                            'name' => 'Téléphone',
                            'slug' => 'telephone',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => false
                        ),
                        array(
                            'name' => 'Mobile',
                            'slug' => 'mobile',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => false
                        ),
                        array(
                            'name' => 'Email',
                            'slug' => 'email',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => false
                        ),
                        array(
                            'name' => 'Adresse',
                            'slug' => 'address',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => true
                        ),
                        array(
                            'name' => 'Quartier',
                            'slug' => 'area_name',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => true
                        ),
                        array(
                            'name' => 'Ville',
                            'slug' => 'town',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'dossiers',
                            'required' => true
                        ),
                        array(
                            'name' => 'Image docteur',
                            'slug' => 'image',
                            'namespace' => 'dossiers',
                            'type' => 'image',
                             'extra' => array('folder' => $imgfolder['data']['id'], 'required' => FALSE), // use id of folder created with core files modules
                            'assign' => 'dossiers',
                            'required' => false
                        ),
                        //category link
                        array(
                            'name' => 'Catégorie',
                            'slug' => 'dossiers_cat',
                            'namespace' => 'dossiers',
                            'type' => 'relationship',
                            'assign' => 'dossiers',
                            'extra' => array('choose_stream' => $categories_stream_id)
                        ),
                        //categories
                        array(
                            'name' => 'Spécialité médicale',
                            'slug' => 'speciality',
                            'namespace' => 'dossiers',
                            'type' => 'text',
                            'assign' => 'categories',
                            'title_column' => true,
                            'required' => true,
                            'unique' => true
                        ),
//                        array(
//                            'name' => 'Domain id',
//                            'slug' => 'domain_id',
//                            'namespace' => 'dossiers',
//                            'type' => 'text',
//                            'assign' => 'categories',
//                            'required' => false,
//                            'hidden' => true
//                        ),
                        array(
                            'name' => 'Catégorie parente',
                            'slug' => 'parent_cat',
                            'namespace' => 'dossiers',
                            'type' => 'relationship',
                            'assign' => 'categories',
                            'extra' => array('choose_stream' => $categories_stream_id),
                            'required' => false
                        ),
                        //organisation link
                        array(
                            'name' => 'Organisme ou groupe',
                            'slug' => 'groupe',
                            'namespace' => 'dossiers',
                            'type' => 'relationship',
                            'assign' => 'dossiers',
                            'extra' => array('choose_stream' => $organisations_stream_id)
                        ),
                        //organisations 
                        array(
                            'name' => 'Structure',
                            'slug' => 'organisation',
                            'namespace' => 'dossiers',
                            'type' => 'relationship',
                            'assign' => 'organisations',
                            'extra' => array('choose_stream' => $organisations_stream_id)
                        ),
                        array(
                            'name' => 'Etablissement',
                            'slug' => 'subset',
                            'namespace' => 'dossiers',
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
        $this->streams->streams->update_stream('dossiers', 'dossiers', array(
            'view_options' => array(
//                'id',
                'days',
                'description',
                'groupe',
                'dossiers_cat'
            )
        )); 
        $this->streams->streams->update_stream('categories', 'dossiers', array(
            'view_options' => array(
//                'id',
                'parent_cat',
                'speciality',
            )
        ));
        $this->streams->streams->update_stream('organisations', 'dossiers', array(
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
        $this->streams->utilities->remove_namespace('dossiers');

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

                 if( !$this->dbforge->add_column('dossiers_categories', $table) ) return false;
        }
        if(version_compare($this->version, '0.0.05', '<=') ) 
        { //DB forge method
            $this->dbforge->drop_column('dossiers_categories', 'parent');
            return true;
        }
        if(version_compare($this->version, '0.0.06', '<=') ) 
        {  //Streams method
                $categories_stream_id = $this->streams->streams->get_stream('categories', 'dossiers' );
                $fields = array(
                        array(
                            'name' => 'Catégorie parente',
                            'slug' => 'parent',
                            'namespace' => 'dossiers',
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
            if ( ! $organisations_stream_id = $this->streams->streams->add_stream('lang:dossiers:organisations', 'organisations', 'dossiers', 'dossiers_', null)) return false; 
            //organisations
            $fields = array(
                            array(
                                'name' => 'Organismes',
                                'slug' => 'organisation',
                                'namespace' => 'dossiers',
                                'type' => 'relationship',
                                'assign' => 'organisations',
                                'extra' => array('choose_stream' => $organisations_stream_id)
                            ),
                            array(
                                'name' => 'Nom organisme',
                                'slug' => 'subset',
                                'namespace' => 'dossiers',
                                'type' => 'text',
                                'assign' => 'organisations',
                                'title_column' => true,
                                'required' => true,
                                'unique' => true
                            )); 
            //update
            $this->streams->fields->add_fields($fields);
            //admin views
            $this->streams->streams->update_stream('organisations', 'dossiers', array(
                'view_options' => array(
                    'id',
                    'organisation', 
                )
            ));
        }
        if(version_compare($this->version, '0.0.92', '<=') ) 
        {
            $this->streams->streams->update_stream('categories', 'dossiers', array(
                'view_options' => array(
                    'id',
                    'parent',
                    'speciality',
                )
            ));
            $this->streams->streams->update_stream('organisations', 'dossiers', array(
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