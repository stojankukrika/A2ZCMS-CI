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
	}
	
	function index()
	{
		echo "Index/ToDoList";
		die();
	}
	function test()
	{
		echo "Test/ToDoList";
		die();
	}

}