<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class UserLoginHistorys extends DataMapper {
	
    public $validation = array(
		'user_id' => array(
			'rules' => array('required', 'integer')
		)
	);
	var $has_many = array("user");
	var $table = "user_login_historys";
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
}

?>