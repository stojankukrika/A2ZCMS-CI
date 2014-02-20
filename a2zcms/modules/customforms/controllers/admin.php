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
		$this->load->model(array("Model_custom_form","Model_custom_form_field"));
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $customform = $this->Model_custom_form->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
 
        $pagination_config = array(
            'base_url' => site_url('admin/customforms/index/'),
            'first_url' => site_url('admin/customforms/index/0'),
            'total_rows' => $this->Model_custom_form->total_rows(),
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
            'customform' => $customform
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
			$this->Model_custom_form->delete($id);
        }
	}
	function deleteitem($custom_formid)
	{
		$id = $this->input->get('id');		
		$this->Model_custom_form_field->delete($id);
		return 0;	
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$customform_edit = $customformfields="";
		$customformfields_count=0;
		if($id>0)
		{
			$customform_edit = $this->Model_custom_form->select($id);
			
			$customformfields = $this->Model_custom_form_field->selectorder('order', $id);
						
			$customformfields_count = $this->Model_custom_form_field->electcount($id);		
		}
		
		$data['content'] = array('customform_edit' => $customform_edit,
								'customformfields' => $customformfields,
								'customformfields_count' => $customformfields_count);
		
		$this->load->view('adminmodalpage', $data);
		$this->form_validation->set_rules('title', "Title", 'required');
		$this->form_validation->set_rules('message', "Message", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			if($id==0)
			{
				$id = $this->Model_custom_form->insert(array('title'=>$this->input->post('title'),
														'message' => $this->input->post('message'),
														'recievers' => $this->input->post('recievers'),
														'user_id' => $this->session->userdata('user_id'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else{
				$this->Model_custom_form->update(array('title'=>$this->input->post('title'),
														'message'=>$this->input->post('message'), 
														'recievers'=>$this->input->post('recievers'), 
														'updated_at' => date("Y-m-d H:i:s")),$id);
									
				$this->Model_custom_form_field->deletefomid($id);
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
				$this->Model_custom_form_field->insert(array('name'=>$params[$i],
														'mandatory'=>$params[$i+1],
														'type'=>$params[$i+2],
														'options'=>$params[$i+3],
														'order'=>$order,
														'custom_form_id'=>$customform_id,
														'user_id'=>$user_id,
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
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
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
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
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
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