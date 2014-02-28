<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_content_vote extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function insert($data) {		
		$this->db->insert('content_votes', $data);
		return $this -> db -> insert_id();
    }
	
}