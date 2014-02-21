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
		$this->load->model("Model_settings");
	}
	
	function index()
	{
		$data['view'] = 'settings';
		$settingsgroup = $this->Model_settings->getSettignsgroup();
		
		$data['content'] = array('settingsgroup'=>$settingsgroup,);
		$this->load->view('adminpage', $data);
		
		$settings_role = $this->Model_settings->getSettignsRule();
		foreach ($settings_role as $item) {
			$this->form_validation->set_rules($item->varname, $item->vartitle, $item->rule);
      	}
		
	    if ($this->form_validation->run() == TRUE)
        {
        	$settings = $this->input->post();
			foreach($settings as $name => $value)
	        {
				$data = array('value'=>$value);
	        	$settings_update = $this->Model_settings->update($name,$data);
	        }
			redirect($this->uri->uri_string());
        }
	}

}