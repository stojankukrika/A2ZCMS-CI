<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_navigation_link extends CI_Model {

	
	function __construct()
	{
		parent::__construct();
	}
    public function getall() {
        $query = $this->db->where(array('deleted_at' => NULL))->get("navigation_links");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {            	
				$row->navigationgroup = $this->db->where(array('deleted_at' => NULL))
												->where('id',$row->page_id)
            									->select('title')->get('navigation_groups')->first_row()->title;
				$row->page = $this->db->where(array('deleted_at' => NULL))
												->where('id',$row->navigation_group_id)
            									->select('title')->get('page')->first_row()->title;
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
			$this->db->update('navigation_links', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('navigation_links')->first_row();
    }
	
	public function selectallparent($id)
	{
		return $this->db->where('id <>', $id)->where(array('deleted_at' => NULL))->get('navigation_links')->result();
	}
	
	public function insert($data) {		
		$this->db->insert('navigation_links', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('navigation_links', $data);
    }
	
}