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
		$this->load->model(array("Model_backup"));
		
	}
	
	function index()
	{
		$data['view'] = 'dashboard';
		
        $data['content'] = array(); 
		
        $this->load->view('adminpage', $data);
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
			/*add to plugins*/
			$data = array(
						   'name' => 'backup' ,
						   'title' => 'Backup' ,
						   'function_id' => NULL,
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
						   'icon' => 'icon-hdd' ,
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data);
			
			/*add plugin permission*/
			$data = array(
						   'name' => 'manage_backup' ,
						   'display_name' => 'Manage backups' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
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
						->where('name','manage_backup')->get()->first_row();
						
			$this->db->delete('manage_backup', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$this->db->delete('permissions', array('name' => 'manage_backup')); 
			
			/*delete plugin functions from pages*/
			$plugin_id = $this->db->select('id')
						->from('plugins')
						->where('name','backup')->get()->first_row();	
			
			/*delete plugin functions*/			
			$this->db->delete('plugin_functions', array('plugin_id' => $plugin_id->id)); 
			
			/*delete plugin*/
			$this->db->delete('plugins', array('id' => $plugin_id->id)); 
			
		}
	}
	
}