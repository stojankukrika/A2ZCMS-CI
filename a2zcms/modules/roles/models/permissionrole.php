<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class PermissionRole extends DataMapper {
	
    public $validation = array(
		'role_id' => array(
			'rules' => array('required', 'integer')
		),
		'role_id' => array(
			'rules' => array('required', 'integer')
		)
	);
	var $has_many = array("permission","role");
	var $table = "permission_role";
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

?>