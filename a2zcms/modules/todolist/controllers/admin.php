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
		$this->load->model(array("Model_todolist"));
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $todolist = $this->Model_todolist->fetch_paging($this->session->userdata('pageitemadmin'),$offset,$this->session->userdata('user_id'));
 
        $pagination_config = array(
            'base_url' => site_url('admin/todolist/index/'),
            'first_url' => site_url('admin/todolist/index/0'),
            'total_rows' => $this->Model_todolist->total_rows($this->session->userdata('user_id')),
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
            'todolist' => $todolist
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$todolist_edit = "";
		
		if($id>0)
		{
			$todolist_edit = $this->Model_todolist->select($id);			
		}
		
		$data['content'] = array('todolist_edit' => $todolist_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$work_done = ($this->input->post('finished')==100.00)?'1':'0';       	
			if($id==0){
				$id = $this->Model_todolist->insert(array('title'=>$this->input->post('title'),
														'user_id' =>$this->session->userdata('user_id'),
														'content' => $this->input->post('content'),
														'finished' => $this->input->post('finished'),
														'work_done' => $work_done,
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_todolist->update(array('title'=>$this->input->post('title'), 
														'content'=>$this->input->post('content'), 
														'finished'=>$this->input->post('finished'), 
														'work_done'=>$work_done, 
														'updated_at'=>date("Y-m-d H:i:s")),$id);
			}
        }
    }
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('todolistid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('todolistid', "Todo-list", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('todolistid');
			$this->Model_todolist->delete($id);
        }
	}
	function change($id) {				
		$todolist_edit = $this->Model_todolist->select($id);
		
		$this->Model_todolist->update(array('finished'=>(($todolist_edit -> work_done + 1) % 2) *100.00, 				
												'work_done'=>($todolist_edit -> work_done + 1) % 2, 
												'updated_at'=>date("Y-m-d H:i:s")),$id);
		return redirect(base_url('admin/todolist'));

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
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."todolists` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `user_id` int(10) unsigned NOT NULL,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `content` text COLLATE utf8_unicode_ci NOT NULL,
					  `finished` decimal(5,2) NOT NULL,
					  `work_done` tinyint(1) NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `todolist_user_id_foreign` (`user_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query2 = "ALTER TABLE `".$database->dbprefix."todolists`
					  ADD CONSTRAINT `todolist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`);";
			$this->db->query($query2);
			
			/*add to plugins*/
			$data = array(
						   'name' => 'todolist' ,
						   'title' => 'To-do list' ,
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
			
			/*add to admin root navigation*/
			$data2 = array(
						   'plugin_id' => $this->db->insert_id() ,
						   'icon' => 'icon-bell' ,
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data2);
			
			/*add plugin permission*/
			$data3 = array(
						   'name' => 'manage_todolists' ,
						   'display_name' => 'Manage todolists' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data3);
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
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_todolists')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$names = array('manage_todolists');
			$this->db->where_in('name', $names);
			$this->db->delete('permissions');
			
			/*delete plugin*/
			$this->db->delete('plugins', array('name' =>'todolist')); 
			
			/*drop todolists tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."todolists`";
			$this->db->query($query);
		}
	}
	

}