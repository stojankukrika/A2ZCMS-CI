<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Plugin extends DataMapper {

	
	function __construct()
	{
		parent::__construct();
	}
	var $table = "plugins";
	
	var $has_one = array ('plugin');
	
}