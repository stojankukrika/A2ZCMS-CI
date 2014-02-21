<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_customform extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("custom_forms");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("custom_forms");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            	$row->countfields = $this->db->where(array('deleted_at' => NULL))
												->where('custom_form_id',$row->id)
            									->count_all_results("custom_form_fields");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   	}
	public function getall()
	{
		return $this->db->where(array('deleted_at' => NULL))->get("custom_forms")->result();
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('custom_forms', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('custom_forms')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('custom_forms', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('custom_forms', $data);
    }
}