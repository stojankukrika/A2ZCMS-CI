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
		$this->load->model(array("Model_customform","Model_customform_field"));
    }
	/*function for plugins*/	
	function getCustomFormId(){
		$customform = $this->Model_customform->getall();
	return array('customform' =>$customform);
	}
	/*function for website part*/
	function showCustomFormId($id)
	{
		echo "Custom form";
	}
		
}
?>