<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class NavigationLink extends DataMapper {

	
	function __construct()
	{
		parent::__construct();
	}
	var $table = "navigation_links";
	
}