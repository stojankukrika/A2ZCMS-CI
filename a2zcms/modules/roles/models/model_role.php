<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_role extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("roles");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("roles");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            	$row->countusers = $this->db->where(array('deleted_at' => NULL))
												->where('role_id',$row->id)
            									->count_all_results("assigned_roles");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('roles', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('roles')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('roles', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('roles', $data);
    }
}