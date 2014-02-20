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
		$data['items'] = $this->Model_menu->read();
		
		//Admin links
		if($this->users->_is_admin()){
			$data['items'][] = $this->Model_menu->menu_admin();
		}
		$data['currentuser'] = @$this->users->userdata();

		$this->load->view("menu", $data);
	}
	
	//Limit access
	function _remap(){
		show_404();
	}
		
}

?>