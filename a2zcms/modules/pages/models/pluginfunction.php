<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class PluginFunction extends DataMapper {

	
	function __construct()
	{
		parent::__construct();
	}
	var $table = "plugin_functions";
	
	var $has_one = array ('plugin');
	
}