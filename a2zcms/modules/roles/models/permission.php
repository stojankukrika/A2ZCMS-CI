<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Permission extends DataMapper {
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    public $validation = array(
		'name' => array(
			'rules' => array('required', 'trim', 'max_length' => 100)
		),
		'display_name' => array(
			'rules' => array('required', 'trim', 'max_length' => 1)
		),
		'is_admin' => array(
			'rules' => array('required', 'trim', 'max_length' => 1)
		)
	);
	
}

?>