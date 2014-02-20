<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_assigned_role extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("assigned_roles");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("assigned_roles");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function getall()
	{
		$query = $this->db->where(array('deleted_at' => NULL))->get("assigned_roles");
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('assigned_roles', $data);
    }
	public function deleteuser($user_id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('user_id', $user_id);
			$this->db->update('assigned_roles', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('assigned_roles')->first_row();
    }
	
	public function selectuser($user_id) {		
		return $this->db->where('user_id', $user_id)->get('assigned_roles')->result();
    }
	
	public function insert($data) {		
		$this->db->insert('assigned_roles', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('assigned_roles', $data);
    }
}