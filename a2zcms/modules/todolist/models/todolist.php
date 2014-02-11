<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Todolist extends DataMapper {
	
	function __construct()
	{
		parent::__construct();
	}
		
    public $validation = array(
		'title' => array(
			'rules' => array('required', 'trim', 'max_length' => 255)
		),
		'content' => array(
			'rules' => array('required', 'trim')
		),
		'finished' => array(
			'rules' => array('required', 'trim')
		),
		'work_done' => array(
			'rules' => array('required', 'trim', 'max_length' => 1)
		)
	);
			
}