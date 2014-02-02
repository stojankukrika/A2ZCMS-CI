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
		$this->load->model("settings_model");
	}
	
	function index()
	{
		$data['view'] = 'settings';
		$data['content'] = '<h2> TESTAROSA </h2> dasjdklasjdklsjadkl asdlska kldsa ';
		$this->load->view('adminpage', $data);
	}

}