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
	public function delete($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('plugin_id', $id);
			$this->db->update('blog_blog_categories', $data);
    }

	public function select($id) {		
		return $this->db->where('blog_id', $id)->get('blog_blog_categories')->result();
    }
	
	public function insert($data) {		
		$this->db->insert('blog_blog_categories', $data); 		
		return $this -> db -> insert_id();
    }
}