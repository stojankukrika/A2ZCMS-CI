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
		$s = $this->settings->getSettigns();
		$data['content'] = $s;
		$this->load->view('adminpage', $data);
		
			$settings_role = new Settings();
			$settings_role->where('rule !=', '')->get();
			foreach ($settings_role as $item) {
				$this->form_validation->set_rules($item->varname, $item->vartitle, $item->rule);
	      	}
			
	       if ($this->form_validation->run() == TRUE)
	        {
	        	$settings = $this->input->post();
				foreach($settings as $name => $data)
		        {
		        	$settings_update = new Settings();
					$settings_update->where('varname',$name)->update('value', $data);
		        }
				redirect($this->uri->uri_string());
	        }
	}

}