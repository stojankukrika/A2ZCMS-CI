<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_blog_category extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("blog_categories");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("blog_categories");
 
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
		$query = $this->db->where(array('deleted_at' => NULL))->get("blog_categories");
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('blog_categories', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('blog_categories')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('blog_categories', $data);
		return $this -> db -> insert_id(); 
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('blog_categories', $data);
    }
}