<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_password_reminder extends CI_Model {
	
    function __construct()
	{
		parent::__construct();
	}
	public function select($id) {		
		return $this->db->where('id', $id)->get('password_reminders')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('password_reminders', $data);
		return $this -> db -> insert_id();
    }	
	
}

?>