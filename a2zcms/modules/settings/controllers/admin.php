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
		$this->load->model("settings");
	}
	
	function index()
	{
		$data['view'] = 'settings';
		$s = new Settings();
		$s->getSettigns();
		$data['content'] = $s;
		$this->load->view('adminpage', $data);
	}

}