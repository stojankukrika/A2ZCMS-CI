<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();						
	}
	
	function index(){
		$data['main_content'] = 'dashboard';
		$this->load->view('adminpage', $data);
	}
	function test()
	{
		echo "TEST";
		die();
	}
		
}

?>