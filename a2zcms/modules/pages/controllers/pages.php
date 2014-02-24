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
		$data['main_content'] = 'index';
		$data['right_content'] = 'users/login';
		$data['menu'] = 'menu';
		$this->load->module('menu/menu');
		$this->menu->mainmenu('top');
		
		$page_id = ($this->uri->segment(3)=="")?$this->uri->segment(3):0;
		$data['current'] = $page_id;
		$this->load->view("page", $data);
	}
	
	public function getsitetitle()
	{
		return $this->db->where('varname', 'title')
						->select('value')
        				->get('settings')->first_row();
	}
}

?>