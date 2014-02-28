<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_permission extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function getallisadmin($is_admin)
	{
		return $this->db->where('is_admin',$is_admin)->where(array('deleted_at' => NULL))->get("permissions")->result();
	}
}