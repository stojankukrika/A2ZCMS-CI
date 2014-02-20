<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_todolist extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function total_rows($user_id) {
        return $this->db->where(array('deleted_at' => NULL))->where('user_id',$user_id)->count_all("todolists");
    }
	
    public function fetch_paging($limit, $start,$user_id) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->where('user_id',$user_id)->get("todolists");
 
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
			$this->db->update('todolists', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('todolists')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('todolists', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('todolists', $data);
    }
			
}