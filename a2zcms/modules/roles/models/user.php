<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Role extends DataMapper {
	
    public $validation = array(
		'name' => array(
			'rules' => array('required', 'trim', 'max_length' => 100)
		),
		'is_admin' => array(
			'rules' => array('required', 'trim', 'max_length' => 1)
		)
	);
	
	
}

?>