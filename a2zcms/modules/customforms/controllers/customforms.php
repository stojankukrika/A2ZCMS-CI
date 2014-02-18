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
    }
	/*function for plugins*/
	function getCustomFormId(){
		$customform = new Customform ();
		$customform->select('id,title')->get();
		return array('customform' =>$customform);
	}
		
}
?>