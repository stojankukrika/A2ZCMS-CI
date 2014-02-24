<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Pages extends Website_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(array("Model_page"));
	}
	
	public function index(){
		
		$page_id = ($this->uri->segment(3)=="")?$this->uri->segment(3):0;
		$pagecontent = Website_Controller::createSiderContent($page_id);
		// Show the page
		 $data['content'] = array(
            'right_content' => $pagecontent['sidebar_right'],
            'left_content' => $pagecontent['sidebar_left'],
            'main_content' => $pagecontent['content']
        );
		$this->load->view("page", $data);
	}
	
	public function getsitetitle()
	{
		return $this->db->where('varname', 'title')
						->select('value')
        				->get('settings')->first_row();
	}
	
	public function search()
	{
		$searchcode = $this->db->where('varname','searchcode')
									->from('settings')->get()->first_row()->varname;
		return "<h4>Search</h4>".$searchcode."<gcse:search></gcse:search>";
	}
	public function login()
	{
		$this->load->module('users/users');
		return $this->users->login();
	}
	public function sideMenu()
	{
		$this->load->module('menu/menu');
		return $this->menu->mainmenu('top');	
	}
	public function content($page_id)
	{
		return $this->db->get('pages')->where('id',$page_id)->first_row();
	}	
	
}

?>