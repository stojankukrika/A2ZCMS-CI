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
	public function getSettigns()
	{
		return $this->db->not_like('groupname', 'version')->get('settings')->result();
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