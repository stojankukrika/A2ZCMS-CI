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
	
	public function countVoteForContent($updown,$content,$id,$user)
	{
		return $this->db->where('content',$content)
							->where('idcontent',$id)
							->where('user_id',$user)
							->select('id')->get('content_votes')->num_rows();
	}
	
}