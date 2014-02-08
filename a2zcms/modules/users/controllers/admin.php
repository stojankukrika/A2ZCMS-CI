<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model("user");					
	}
	
	function index(){
		$data['view'] = 'dashboard';
		$users = $this->user->get();
		$data['content'] = $users;
		$this->load->view('adminpage', $data);
	}
		
}

?>