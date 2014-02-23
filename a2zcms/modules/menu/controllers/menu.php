<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Menu extends Website_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Model_menu");
		$this->load->module("users");
	}
	
	function index(){
		$data['current'] = $this->uri->segment(1);
		$data['items'] = $this->Model_menu->pagesmenu('top');
		$data['sitename'] = $this->getsitetitle()->value;
		//Admin links
		if($this->users->_is_admin($this->session->userdata('user_id'))){
			$data['admin'] = $this->Model_menu->menu_admin();
		}
		$data['currentuser'] = @$this->users->userdata();

		$this->load->view("menu", $data);
	}
	
	
	public function getsitetitle()
	{
		return $this->db->where('varname', 'title')
						->select('value')
        				->get('settings')->first_row();
	}
}

?>