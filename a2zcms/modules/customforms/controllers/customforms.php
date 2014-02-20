<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Customforms extends Website_Controller{

	function __construct()
    {
        parent::__construct();
		$this->load->model(array("Model_custom_form","Model_custom_form_field"));
    }
	/*function for plugins*/
	function getCustomFormId(){
		$customform = $this->Model_custom_form->getall();
		return array('customform' =>$customform);
	}
		
}
?>