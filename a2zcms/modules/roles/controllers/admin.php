<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();	
		$this->load->model("role");						
	}
	
	function index(){
		$data['view'] = 'dashboard';
		$roles = $this->role->get();
		$data['content'] = $roles;
		$this->load->view('adminpage', $data);
	}
}

?>