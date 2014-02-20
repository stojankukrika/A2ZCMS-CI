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
	public function getSettignsgroup()
	{
		return $this->db->not_like('groupname', 'version')->group_by('groupname')->get('settings')->result();
	}
	
	public function getSettignsForGroup($groupname)
	{
		return $this->db->where('groupname', $groupname)->get('settings')->result();
	}
	
	public function getSettignsRule()
	{
		return $this->db->not_like('groupname', 'version')->where('rule !=', '')->get('settings')->result();
	}
	public function update($varname,$data) {		
		$this->db->where('varname', $varname);
		$this->db->update('settings', $data);
    }
}