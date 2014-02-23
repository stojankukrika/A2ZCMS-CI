<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Pages extends Website_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(array("Model_page"));
	}
	
	public function index(){
		echo $this->uri->segment(3);
		$data['current'] = $this->uri->segment(3);
		$this->load->view("index", $data);
	}
	
	public function getsitetitle()
	{
		return $this->db->where('varname', 'title')
						->select('value')
        				->get('settings')->first_row();
	}
}

?>