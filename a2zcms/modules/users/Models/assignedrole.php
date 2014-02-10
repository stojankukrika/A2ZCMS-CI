<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class AssignedRole extends DataMapper {
	
    public $validation = array(
		'role_id' => array(
			'rules' => array('required', 'integer')
		),
		'user_id' => array(
			'rules' => array('required', 'integer')
		)
	);
	var $has_many = array("user","role");
	var $table = "assigned_roles";
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

?>