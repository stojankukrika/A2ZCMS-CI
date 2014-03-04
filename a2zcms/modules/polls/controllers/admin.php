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
		$this->load->model(array("Model_poll"));
		
	}
	function index(){
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $polls = $this->Model_poll->fetch_paging($this->session->userdata('pageitemadmin'),$offset,$this->session->userdata('user_id'));

        $pagination_config = array(
            'base_url' => site_url('admin/polls/index/'),
            'first_url' => site_url('admin/polls/index/0'),
            'total_rows' => $this->Model_poll->total_rows($this->session->userdata('user_id')),
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
            'polls' => $polls
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'create_edit';

		$poll_edit = "";
		$poll_options = array();
		$poll_options_count = 0;
		
		if($id>0)
		{
			$poll_edit = $this->Model_poll->select($id);
			$poll_options = $this->Model_poll->selectOptions($id);			
			$poll_options_count = $this->Model_poll->countOptions($id);
		}
		
		$data['content'] = array('poll_edit' => $poll_edit, 'poll_options' => $poll_options,'poll_options_count' => $poll_options_count);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('poll', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	if($id==0){
				$id = $this->Model_poll->insert(array('title'=>$this->input->post('poll'),
														'user_id' =>$this->session->userdata('user_id'),
														'active' => 0,
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_poll->update(array('title'=>$this->input->post('poll'), 
														'updated_at'=>date("Y-m-d H:i:s")),$id);
			}
			if($this->input->post('pagecontentorder')!=""){
					$this->saveFilds($this->input->post('pagecontentorder'),$this->input->post('count'),$id,$this->session->userdata('user_id'));
				}
        }
    }

	public function saveFilds($pagecontentorder,$count,$poll_id,$user_id)
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		
		$params = explode(',', $pagecontentorder);
		$order = 1;
		for ($i=0; $i <= $count*2-1; $i=$i+2) {
			if($params[$i]!=""){
				if($params[$i+1]!="")
				{
					$this->Model_poll->updateOption(array('title'=>$params[$i],
												'order'=>$order,
												'updated_at' => date("Y-m-d H:i:s")), $params[$i+1]);
				}
				else {
				$this->Model_poll->insertOption(array('title'=>$params[$i],
												'poll_id' =>$poll_id,
												'order'=>$order,
												'votes'=>0,												
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
				}
			}
			$order++;
		}
	}
	
	function delete($id)
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'delete';
		$data['content'] = array('pollid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('pollid', "Poll", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('pollid');
			$this->Model_poll->delete($id);
        }
	}
	
	function deleteitem()
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->get('id');		
		$this->Model_poll->deleteOption($id);
		return 0;	
	}
	
	function change($id) 
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}				
		$poll_edit = $this->Model_poll->select($id);
		
		$this->Model_poll->update(array('active'=>($poll_edit -> active + 1) % 2, 
												'updated_at'=>date("Y-m-d H:i:s")),$id);
		return redirect(base_url('admin/polls'));
	}
	
	function results($id)
	{
		if (!$this->session->userdata("manage_polls")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'results';
		
        $poll = $this->Model_poll->select($id);
		$pollOptions = $this->Model_poll->selectOptions($id);
		$pollTotalVotes = $this->Model_poll->selectSumVotes($id);
		if($pollTotalVotes==0)$pollTotalVotes=1;
		
		foreach ($pollOptions as $item) {
			$item->percentage = number_format(( intval($item->votes)/$pollTotalVotes) * 100, 2 ) . '%' ;
		}		
		
        $data['content'] = array(
            'poll' => $poll,
            'pollOptions'=>$pollOptions
        );
 
        $this->load->view('adminpage', $data);
	}
	
	
	/*Install*/
	function install()
	{
		if (!$this->session->userdata("manage_plugins")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$database = $this->load->database('default', TRUE);				
		$data['view'] = 'install';
		$data['content'] = array();
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."polls` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `user_id` int(10) unsigned NOT NULL,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'if the poll is active or not',
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `polls_user_id_foreign` (`user_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."polls`
					  ADD CONSTRAINT `polls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`);";
			$this->db->query($query);
			
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."poll_options` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `poll_id` int(10) unsigned NOT NULL,
					  `votes` int(11) DEFAULT '0',
					  `order` int(11) DEFAULT '0',
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `options_polls_id_foreign` (`poll_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."poll_options`
					  ADD CONSTRAINT `options_polls_id_foreign` FOREIGN KEY (`poll_id`) REFERENCES `".$database->dbprefix."polls` (`id`);";
			$this->db->query($query);

			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."poll_votes` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `option_id` int(10) unsigned NOT NULL,
					  `ip_address` varchar(45) NOT NULL DEFAULT '' COMMENT 'max ipv6',
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `votes_options_id_foreign` (`option_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);			
			
			$query = "ALTER TABLE `".$database->dbprefix."poll_votes`
					  ADD CONSTRAINT `votes_options_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `".$database->dbprefix."poll_options` (`id`);";
			$this->db->query($query);
			
			/*add to plugins*/
			$data = array(
						   'name' => 'polls' ,
						   'title' => 'Polls' ,
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
						   'icon' => 'icon-signal' ,
						   'background_color'=> 'yellow',
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data);
			
			/*add plugin permission*/
			$data = array(
						   'name' => 'manage_polls' ,
						   'display_name' => 'Manage polls' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			/*add plugin function*/
			$data = array(
						   'title' => 'Active poll' ,
						   'plugin_id' => $plugin_id,
						   'function' => 'activePoll',
						   'params' => 'sort:asc;order:id;limit:1;',
						   'type' => 'sidebar',
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
		if (!$this->session->userdata("manage_plugins")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$database = $this->load->database('default', TRUE);						
		$data['view'] = 'uninstall';
		$data['content'] = array();
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_polls')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$names = array('manage_polls');
			$this->db->where_in('name', $names);
			$this->db->delete('permissions');
			
			$plugin_id = $this->db->select('id')
						->from('plugins')
						->where('name','polls')->get()->first_row();
						
			/*delete admin navigation*/			
			$navigation = $this->db->select('admin_navigations', array('plugin_id' => $plugin_id->id));
			
			$this->db->delete('admin_subnavigations', array('admin_navigation_id' => $navigation->id));			
			$this->db->delete('admin_navigations', array('id' => $navigation->id)); 	
			
			/*delete from pages*/
			$function = $this->db->select('plugin_functions', array('plugin_id' => $plugin_id->id));
			$this->db->delete('page_plugin_functions', array('plugin_function_id' => $function->id)); 	
			$this->db->delete('plugin_functions', array('plugin_id' => $plugin_id->id)); 	
			
			/*delete plugin*/
			$this->db->delete('plugins', array('name' =>'polls')); 
			
			/*drop todolists tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."poll_votes`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."poll_options`";
			$this->db->query($query);

			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."polls`";
			$this->db->query($query);
		}
	}
	

}