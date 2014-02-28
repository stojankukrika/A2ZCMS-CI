<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_customform_field extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("custom_form_fields");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("custom_form_fields");
 
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
		return $this->db->where(array('deleted_at' => NULL))->get("custom_form_fields")->result();
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('custom_form_fields', $data);
    }
	
	public function deletefomid($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('custom_form_id', $id);
			$this->db->update('custom_form_fields', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->where(array('deleted_at' => NULL))->get('custom_form_fields')->first_row();
    }
	
	public function selectorder($order,$id) {		
		return $this->db->where('custom_form_id', $id)->where(array('deleted_at' => NULL))->order_by($order,'ASC')->get('custom_form_fields')->result();
    }
	
	public function selectcount($id) {		
		return $this->db->where('custom_form_id', $id)->where(array('deleted_at' => NULL))->count_all('custom_form_fields');
    }
	
	public function insert($data) {		
		$this->db->insert('custom_form_fields', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('custom_form_fields', $data);
    }
	public function selectForId($id) {		
		return $this->db->where('custom_form_id', $id)
								->where(array('deleted_at' => NULL))
								->select('id, name, options, type, order, mandatory')
								->order_by('order','ASC')
								->get('custom_form_fields')->result();
    }
}