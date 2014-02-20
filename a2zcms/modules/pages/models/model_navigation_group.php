<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_navigation_group extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("navigation_groups");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("navigation_groups");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
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
			$this->db->update('navigation_groups', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('navigation_groups')->first_row();
    }
	public function getall() {		
		return $this->db->where(array('deleted_at' => NULL))->get('navigation_groups')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('navigation_groups', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('navigation_groups', $data);
    }
}