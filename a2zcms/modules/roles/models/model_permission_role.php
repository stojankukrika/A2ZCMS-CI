<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_permission_role extends CI_Model {
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
   
	public function delete($role_id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('role_id', $role_id);
			$this->db->update('permission_role', $data);
    }

	public function selectrole($role_id)
	{
		return $this->db->where('role_id',$role_id)->get('permission_role')->result();
	}
	
	public function insert($data) {		
		$this->db->insert('permission_role', $data);
		return $this -> db -> insert_id();
    }
}