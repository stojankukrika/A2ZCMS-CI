<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();
		
		$this->load->module("users");
		$this->load->module("admin");
		
		if(!$this->session->userdata('admin_logged_in')){
			 redirect('');
		}
		
	}
	
	function index(){
		$data['main_content'] = 'dashboard';
		$this->load->view('adminpage', $data);
	}
		
}

?>