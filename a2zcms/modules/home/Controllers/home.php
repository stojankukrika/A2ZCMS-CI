<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Home extends Website_Controller{

	function __construct()
    {
        parent::__construct();
    }
	function index(){
		$data['main_content'] = 'index';
		//$data['menu'] = 'menu';
		//$this->load->module('menu/menu');
		//$this->menu->index();
		$this->load->view('page', $data);
	}
		
}

?>