<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class User extends DataMapper {
	
    public $validation = array(
		'name' => array(
			'rules' => array('required', 'trim', 'unique', 'max_length' => 100)
		),
		'email' => array(
			'rules' => array('required', 'trim', 'unique', 'valid_email')
		),
		'username' => array(
			'rules' => array('required', 'trim', 'unique', 'alpha_dash', 'min_length' => 3, 'max_length' => 20)
		),
		'password' => array(
			'rules' => array('required', 'trim', 'min_length' => 3, 'max_length' => 40, 'encrypt'),
			'type' => 'password'
		),
		'confirm_password' => array(
			'rules' => array('required', 'encrypt', 'matches' => 'password', 'min_length' => 3, 'max_length' => 40),
			'type' => 'password'
		),
		'group' => array(
			'rules' => array('required')
		)
	);
	// Default to ordering by name
	public $default_order_by = array('name');
}

?>