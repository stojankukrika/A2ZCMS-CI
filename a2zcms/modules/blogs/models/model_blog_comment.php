<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_blog_comment extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("blog_comments");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("blog_comments");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function total_rows_blog($blog_id) {
        return $this->db->where(array('deleted_at' => NULL))->where('blog_id',$blog_id)->count_all("blog_comments");
    }
	
    public function fetch_paging_blog($limit, $start,$blog_id) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->where('blog_id',$blog_id)->get("blog_comments");
 
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
			$this->db->update('blog_comments', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('blog_comments')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('blog_comments', $data); 
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('blog_comments', $data);
    }
}