<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_blog extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("blogs");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("blogs");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            	$row->countcomments = $this->db->where(array('deleted_at' => NULL))
												->where('blog_id',$row->id)
            									->count_all_results("blog_comments");
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	public function getall()
	{
		return $this->db->where(array('deleted_at' => NULL))->get("blogs")->result();
	}
	
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('blogs', $data);
    }

	public function select($id) {		
		return $this->db->where('id', $id)->get('blogs')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('blogs', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('blogs', $data);
    }
}