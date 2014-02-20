<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_gallery_image_comment extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("gallery_images_comments");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("gallery_images_comments");
 
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
		$query = $this->db->where(array('deleted_at' => NULL))->get("gallery_images_comments");
	}
	
	public function fetch_paging_gallery($limit, $start,$gallery_id) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->where('gallery_id',$gallery_id)->get("gallery_images_comments");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function total_rows_gallery($gallery_id) {
        return $this->db->where(array('deleted_at' => NULL))->where('gallery_id',$gallery_id)->count_all("gallery_images_comments");
    }
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('gallery_images_comments', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('gallery_images_comments')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('gallery_images_comments', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('gallery_images_comments', $data);
    }
}