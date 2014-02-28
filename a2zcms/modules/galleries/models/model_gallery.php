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
            									->count_all_results("gallery_images_comments");
				$row->countimages = $this->db->where(array('deleted_at' => NULL))
												->where('gallery_id',$row->id)
            									->count_all_results("gallery_images");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function getall()
	{
		return $this->db->where(array('deleted_at' => NULL))->get("galleries")->result();
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
    public function selectFirst() {		
		return $this->db->select('id')->limit(1)->get('galleries')->first_row()->id;
    }
	public function selectById($id)
	{
		$gallery = $this->db->where('galleries.id',$id)
								->from('galleries')
								->join('users','galleries.user_id=users.id')
								->select('galleries.*,CONCAT(name ,'.'," " ,'.', surname) as fullname', FALSE)
								->get()->first_row();
		if(!empty($gallery))
		{
			$datatemp = array(
               'hits' => $gallery->hits + 1,
           		);
			$this->update($datatemp,$gallery->id);
		}
		return $gallery;
	}
	
	public function getAllByParams($order,$sort,$limit)
	{
		return  $this->db->order_by($order,$sort)
						->limit($limit)->select('id, title')->get('galleries')->result();
	}
	
	public function selectWhereIn($ids,$orders,$sorts)
	{
		return $this->db->where('start_publish <=','CURDATE()')
									->where('(end_publish IS NULL OR end_publish >= CURDATE())')
									->where_in('id', $ids)
									->order_by($orders,$sorts)
									->select('id, title, folderid')->get('galleries')->result();
	}
	
	public function selectLimit($limits,$orders,$sorts)
	{		
		return $this->db->where('start_publish <=','CURDATE()')
									->where('(end_publish IS NULL OR end_publish >= CURDATE())')
									->orderBy($orders,$sorts)
									->take($limits)
									->select('id','title','folderid')->get('galleries')->result();
	} 
}
