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
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("permissions");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("permissions");
 
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
		$query = $this->db->where(array('deleted_at' => NULL))->get("permissions");
	}
	
	public function getallisadmin($is_admin)
	{
		$query = $this->db->where('is_admin',$is_admin)->where(array('deleted_at' => NULL))->get("permissions");
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('permissions', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('permissions')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('permissions', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('permissions', $data);
    }
}