<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Admin extends Administrator_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $customform = new Customform();
        $customform->where(array('deleted_at' => NULL))->where('user_id',$this->session->userdata('user_id'))
			->select('id,title,recievers,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
		foreach ($customform as $item) {
 			$customformfield = new Customformfield();		
			$customformfield->where('custom_form_id', $item->id)->where(array('deleted_at' => NULL));
			$item->countfields = $customformfield->count();			
		 }
		
        if ($offset > $customform->paged->total_rows) {
            $offset = floor($customform->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/customforms/index/'),
            'first_url' => site_url('admin/customforms/index/0'),
            'total_rows' => $customform->paged->total_rows,
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 4,
           	'full_tag_open' => '<ul class="pagination">',
			'first_tag_open' => '<li>',
			'first_link' => '<span class="icon-fast-backward"></span>',
		    'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_link' => '<span class="icon-fast-forward"></span>',
			'last_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_link' => '<span class="icon-step-forward"></span>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_link' => '<span class="icon-step-backward"></span>',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'full_tag_close' => '</ul>',
        );		
		
        $this->pagination->initialize($pagination_config);
 
        $data['content'] = array(
            'pagination' => $this->pagination,
            'customform' => $customform,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}

	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('customformid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('customformid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('customformid');
			
			$customform = new Customform();
			$customform->where('id', $id)->where('user_id',$this->session->userdata('user_id'))
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	function deleteitem($custom_formid)
	{
		$id = $this->input->get('id');
		
		$customformfield = new CustomFormField();
		$customformfield->where('id', $id)->where('custom_form_id',$custom_formid)
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
		return 0;	
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$customform_edit = $customformfields="";
		$customformfields_count=0;
		if($id>0)
		{
			$customform_edit = new Customform();
			$customform_edit->select('id,title,recievers,message')
			->where('id',$id)->get();	
			
			$customformfields = new Customformfield();
			$customformfields->select('id,custom_form_id,name,options,type,`order`,mandatory')
			->order_by("order", "ASC")
			->where(array('deleted_at' => NULL))
			->where('custom_form_id',$id)->get();
			
			$customformfields_count = new Customformfield();
			$customformfields_count = $customformfields_count->select('id')
			->where(array('deleted_at' => NULL))
			->where('custom_form_id',$id)->count();		
		}
		
		$data['content'] = array('customform_edit' => $customform_edit,
								'customformfields' => $customformfields,
								'customformfields_count' => $customformfields_count);
		
		$this->load->view('adminmodalpage', $data);
		$this->form_validation->set_rules('title', "Title", 'required');
		$this->form_validation->set_rules('message', "Message", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$customform = new CustomForm();
			if($id==0)
			{			
				$customform->title = $this->input->post('title');
				$customform->message = $this->input->post('message');
				$customform->recievers = $this->input->post('recievers');
				$customform->user_id = $this->session->userdata('user_id');
				$customform->updated_at = date("Y-m-d H:i:s");										
				$customform->created_at = date("Y-m-d H:i:s");
				$customform->save();
				$id = $customform->id;
			}
			else{
				$customform->where('id', $id)->update(array('title'=>$this->input->post('title'), 
							'message'=>$this->input->post('message'), 
							'recievers'=>$this->input->post('recievers'), 
							'updated_at'=>date("Y-m-d H:i:s")));
					
				$c = new CustomFormField();
				$c->where('custom_form_id', $id)->update('deleted_at', date("Y-m-d H:i:s"));
			}
			
			if($this->input->post('pagecontentorder')!=""){
					$this->saveFilds($this->input->post('pagecontentorder'),$this->input->post('count'),$id,$this->session->userdata('user_id'));
				}	
        	
		}
    }

	public function saveFilds($pagecontentorder,$count,$customform_id,$user_id)
	{
		$params = explode(',', $pagecontentorder);
		$order = 1;
		for ($i=0; $i <= $count*4-1; $i=$i+4) {
			if($params[$i]!=""){
				$customformfield = new CustomFormField();
				$customformfield -> name = $params[$i];
				$customformfield -> mandatory = $params[$i+1];
				$customformfield -> type = $params[$i+2];
				$customformfield -> options = $params[$i+3];
				$customformfield -> order = $order;
				$customformfield -> custom_form_id = $customform_id;
				$customformfield -> user_id = $user_id;	
				$customformfield -> updated_at = date("Y-m-d H:i:s");										
				$customformfield -> created_at = date("Y-m-d H:i:s");					
				$customformfield -> save();	
			}
			$order++;
		}
	}
	
	
	/*Install*/
	function install()
	{
		$database = $this->load->database('default', TRUE);				
		$data['view'] = 'install';
		$data['content'] = array();
		if (!empty($_POST))
		{
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."custom_forms` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `user_id` int(10) unsigned NOT NULL,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `recievers` text COLLATE utf8_unicode_ci,
					  `message` text COLLATE utf8_unicode_ci NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `custom_forms_user_id_index` (`user_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."custom_form_fields` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `custom_form_id` int(10) unsigned NOT NULL,
					  `user_id` int(10) unsigned NOT NULL,
					  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `options` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `type` int(11) NOT NULL,
					  `order` int(11) NOT NULL,
					  `mandatory` tinyint(1) NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `custom_form_fields_custom_form_id_index` (`custom_form_id`),
					  KEY `custom_form_fields_user_id_index` (`user_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."custom_forms`
					  ADD CONSTRAINT `custom_forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`) ON DELETE CASCADE;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."custom_form_fields`
					  ADD CONSTRAINT `custom_form_fields_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`) ON DELETE CASCADE,
					  ADD CONSTRAINT `custom_form_fields_custom_form_id_foreign` FOREIGN KEY (`custom_form_id`) REFERENCES `".$database->dbprefix."custom_forms` (`id`) ON DELETE CASCADE;";
			$this->db->query($query);
			
			/*add to plugins*/
			$data = array(
						   'name' => 'customforms' ,
						   'title' => 'Custom form' ,
						   'function_id' => 'getCustomFormId',
						   'function_grid' => NULL,
						   'can_uninstall' => '1',
						   'pluginversion' => '1.0',
						   'active' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugins', $data);
			$plugin_id = $this->db->insert_id();
			
			/*add to admin root navigation*/
			$data = array(
						   'plugin_id' => $plugin_id ,
						   'icon' => 'icon-list-alt' ,
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data);
			
			/*add plugin permission*/
			$data = array(
						   'name' => 'manage_customform' ,
						   'display_name' => 'Manage custom forms' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			/*add plugin function*/
			$data = array(
						   'title' => 'Display custom form' ,
						   'plugin_id' => $plugin_id,
						   'function' => 'showCustomFormId',
						   'params' => 'id;',
						   'type' => 'content',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugin_functions', $data);
		}
	}
	/*Uninstall*/
	function uninstall()
	{
		$database = $this->load->database('default', TRUE);				
		$data['view'] = 'uninstall';
		$data['content'] = array();
		if (!empty($_POST))
		{		
			/*delete permissions from roles*/	
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_customform')->get()->first_row();
						
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$this->db->delete('permissions', array('name' => 'manage_customform')); 
			
			/*delete plugin functions from pages*/
			$plugin_id = $this->db->select('id')
						->from('plugins')
						->where('name','customforms')->get()->first_row();
			
			$plugins = $this->db->select('id')
						->from('plugin_functions')
						->where('plugin_id',$plugin_id->id)->get()->result();
						
			foreach ($plugins as $item) {
					$data = array(
			               'deleted_at' => date("Y-m-d H:i:s")
			            );
			
					$this->db->where('plugin_function_id', $item->id);
					$this->db->update('page_plugin_functions', $data); 
			}		
			
			/*delete plugin functions*/			
			$this->db->delete('plugin_functions', array('plugin_id' => $plugin_id->id)); 
			
			/*delete plugin*/
			$this->db->delete('plugins', array('id' => $plugin_id->id)); 
			
			/*drop custom_form tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."custom_form_fields`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."custom_forms`";
			$this->db->query($query);
		}
	}
	
}