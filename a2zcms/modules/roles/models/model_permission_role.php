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
    public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("permission_role");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("permission_role");
 
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
		return $this->db->where(array('deleted_at' => NULL))->get("permission_role")->result();
	}
	
	public function delete($role_id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('role_id', $role_id);
			$this->db->update('permission_role', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('permission_role')->first_row();
    }
	public function selectrole($role_id)
	{
		return $this->db->where('role_id',$role_id)->get('permission_role')->result();
	}
	
	public function insert($data) {		
		$this->db->insert('permission_role', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('permission_role', $data);
    }
}