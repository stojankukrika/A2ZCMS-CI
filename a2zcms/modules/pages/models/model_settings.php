<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_settings extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
	public function getSettignsForGroup($groupname)
	{
		return $this->db->where('groupname', $groupname)->get('settings')->result();
	}
}