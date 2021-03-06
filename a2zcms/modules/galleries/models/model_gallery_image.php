<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_gallery_image extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("gallery_images");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("gallery_images");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            	$row->countcomments = $this->db->where(array('deleted_at' => NULL))
												->where('gallery_image_id',$row->id)
            									->count_all_results("gallery_images_comments");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function getall()
	{
		return $this->db->where(array('deleted_at' => NULL))->get("gallery_images")->result();
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('gallery_images', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('gallery_images')->first_row();
    }
	
	public function selectgalery($galery_id,$limit=0) {
		if($limit==0){
			return $this->db->where('gallery_id', $galery_id)->where(array('deleted_at' => NULL))->get('gallery_images')->result();
		}
		else {
			return $this->db->where('gallery_id', $galery_id)->limit($limit)->where(array('deleted_at' => NULL))->get('gallery_images')->result();
		}
    }
	
	public function insert($data) {		
		$this->db->insert('gallery_images', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('gallery_images', $data);
    }
	public function selectForId($id) {		
		$gallery_image = $this->db->where('id', $id)->get('gallery_images')->first_row();
		
		if(!empty($gallery_image))
		{
			$datatemp = array(
               'hits' => $gallery_image->hits + 1,
           		);
			$this->update($datatemp,$gallery_image->id);
		}
		return $gallery_image;
    }
}