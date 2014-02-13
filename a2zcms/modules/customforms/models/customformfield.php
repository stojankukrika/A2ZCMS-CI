<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Customformfield extends DataMapper {
	
	function __construct()
	{
		parent::__construct();
	}
	
	var $table = "custom_form_fields";
			
}