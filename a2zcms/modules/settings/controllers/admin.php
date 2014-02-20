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
		
		$settingstable = "";
		foreach ($settingsgroup as $group) {
				$settingstable.='<div class="tab-pane active" id="' . $group -> groupname . '">';				
				foreach ($this->Model_settings->getSettignsForGroup($group -> groupname) as $item) {
					$settingstable.='<div class="form-group">
							<div class="col-md-12">';
					switch ($item->type) {
						case 'text' :							
							$settingstable.= $this -> form_builder -> text($item -> varname, $item -> vartitle, $item -> value, 'form-control');
							break;
						case 'textarea' :
							$settingstable .= $this -> form_builder -> textarea($item -> varname, $item -> vartitle, $item -> value, 'form-control');
							break;
						case 'radio' :
							$variables = explode(";", $item -> defaultvalue);
							$radios = array();

							foreach ($variables as $variable) {
								$radios[] = (object) array('id' => $variable, 'name' => $variable);
							}
							$settingstable .= $this -> form_builder -> radio($item -> varname, $item -> vartitle, $radios, $item -> value, 'form-control');
							break;
						case 'option' :
							$options = array();
							if (strpos($item -> defaultvalue, ';') === false) {
								foreach (glob(constant($item -> defaultvalue) . '/*', GLOB_ONLYDIR) as $dir) {
									$dir = str_replace(constant($item -> defaultvalue).'/', '', $dir);
									$options[] = (object) array('id' => $dir, 'name' => ucfirst($dir));
								}
							} else {
								$variables = explode(";", $item -> defaultvalue);
								foreach ($variables as $variable) {
									$options[] = (object) array('id' => $variable, 'name' => $variable);
								}
							}
							$settingstable .= $this -> form_builder -> option($item -> varname, $item -> vartitle, $options, $item -> value, 'form-control');
							break;
						case 'checkbox' :
							$variables = explode(";", $item -> defaultvalue);
							$checkboxes = array();
							foreach ($variables as $variable) {
								$checkboxes[] = (object) array('id' => $variable, 'name' => $variable);
							}
							$settingstable .= $this -> form_builder -> checkboxes($item -> varname, $item -> vartitle, $checkboxes, $item -> value, 'form-control');
							break;
						case 'password' :
							$settingstable .= $this -> form_builder -> password($item -> varname, $item -> vartitle, $item -> value, 'form-control');
						case 'date' :
							$settingstable .= $this -> form_builder -> date($item -> varname, $item -> vartitle, $item -> value, 'form-control');
					}
					$settingstable.= "</div>
						</div>";
				}
				$settingstable.="</div>";
			}

		$data['content'] = array('settingstable'=>$settingstable,'settingsgroup'=>$settingsgroup,);
		$this->load->view('adminpage', $data);
		
		$settings_role = $this->Model_settings->getSettignsRule();
		foreach ($settings_role as $item) {
			$this->form_validation->set_rules($item->varname, $item->vartitle, $item->rule);
      	}
		
	    if ($this->form_validation->run() == TRUE)
        {
        	$settings = $this->input->post();
			foreach($settings as $name => $data)
	        {
	        	$settings_update = $this->Model_settings->update($name,$data);
	        }
			redirect($this->uri->uri_string());
        }
	}

}