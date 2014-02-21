<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_blog_blog_category extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	public function delete($blog_id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('blog_id', $blog_id);
			$this->db->update('blog_blog_categories', $data);
    }

	public function select($blog_id) {		
		return $this->db->where('blog_id', $blog_id)->where(array('deleted_at' => NULL))->select('blog_category_id as id')->get('blog_blog_categories')->result_array();
    }
	
	public function insert($data) {		
		$this->db->insert('blog_blog_categories', $data); 		
		return $this -> db -> insert_id();
    }
}