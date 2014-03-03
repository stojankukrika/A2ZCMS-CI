<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_poll extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function total_rows($user_id) {
        return $this->db->where(array('deleted_at' => NULL))
        				->where('user_id',$user_id)
        				->count_all("polls");
    }
	
    public function fetch_paging($limit, $start,$user_id) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))
        				->where('user_id',$user_id)
        				->get("polls");
 
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
			$this->db->update('polls', $data);
    }
	
	public function deleteOption($id) {		
		$data = array(
               'deleted_at' => date("Y-m-d H:i:s")
            );
			$this->db->where('id', $id);
			$this->db->update('poll_options', $data);
    }	

	public function select($id) {		
		return $this->db->where('id', $id)->get('polls')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('polls', $data);
		return $this -> db -> insert_id();
    }
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('polls', $data);
    }
	
	public function selectOptions($poll_id)
	{
		return $this->db->where('poll_id', $poll_id)
						->where(array('deleted_at' => NULL))
						->order_by('order','ASC')
						->select('id,title,votes')
						->get('poll_options')
						->result();
	}
	
	public function selectSumVotes($poll_id)
	{
		return $this->db->where('poll_id', $poll_id)
						->where(array('deleted_at' => NULL))
						->select_sum('votes')
						->get('poll_options')->first_row()->votes;
	}
	
	public function countOptions($poll_id)
	{
		return $this->db->where('poll_id', $poll_id)
						->where(array('deleted_at' => NULL))
						->count_all("poll_options");
	}
	
	public function insertOption($data) {		
		$this->db->insert('poll_options', $data);
		return $this -> db -> insert_id();
    }
	
	public function updateOption($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('poll_options', $data);
    }
	
	public function getAllByParams($order,$sort,$limit)
	{
		return  $this->db->order_by($order,$sort)
						->limit($limit)
						->where('active','0')
						->where(array('deleted_at' => NULL))
						->select('id, title')
						->get('polls')
						->first_row();
	}
	
	public function chechUserVoted($poll_id,$ip_address)
	{
		$votes = $this->db->where(array('poll_options.deleted_at' => NULL))
						->where('ip_address',$ip_address)
						->where('poll_id',$poll_id)
						->from('poll_options')
						->join('poll_votes','poll_options.id=poll_votes.option_id')
						->count_all_results();
		return $votes>0?false:true;
	}
	
	public function insertVote($data) {		
		$this->db->insert('poll_votes', $data);
		return $this -> db -> insert_id();
    }
			
}