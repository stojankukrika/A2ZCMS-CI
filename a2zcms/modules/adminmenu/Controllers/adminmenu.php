<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdminMenu extends Website_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("admin_menu_model");
		$this->load->module("users");
	}
	
	function head_navigation(){
		$data['current'] = $this->uri->segment(1);
		$data['currentuser'] = @$this->users->userdata();
		$this->load->view("adminmenu",$data);
	}
	function left_navigation(){
		$data['current'] = $this->uri->segment(1);
		//Admin links
		if($this->users->_is_admin()){
			$data['items'] = $this->admin_menu_model->menu_admin();
		}
		
		$data['currentuser'] = @$this->users->userdata();
		$this->load->view("adminleftmenu", $data);
	}
		
}

?>