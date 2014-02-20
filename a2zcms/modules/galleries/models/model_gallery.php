<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_gallery extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("galleries");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("galleries");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            	$row->countcomments = $this->db->where(array('deleted_at' => NULL))
												->where('gallery_image_id',$row->id)
            									->count_all("gallery_images_comments");
				$row->countimages = $this->db->where(array('deleted_at' => NULL))
												->where('gallery_id',$row->id)
            									->count_all("gallery_images");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function getall()
	{
		$query = $this->db->where(array('deleted_at' => NULL))->get("galleries");
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('galleries', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('galleries')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('galleries', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('galleries', $data);
    }
}
