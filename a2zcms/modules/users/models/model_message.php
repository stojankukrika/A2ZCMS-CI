<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_message extends CI_Model {
	
    function __construct()
	{
		parent::__construct();
	}
	public function select($id) {		
		return $this->db->where('id', $id)->get('messages')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('messages', $data);
		return $this -> db -> insert_id();
    }	
	
	public function deletesender($id) {		
		$data = array(
               'deleted_at_sender' => date("Y-m-d H:i:s")
            );
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
    }
	public function deletereceiver($id) {		
		$data = array(
               'deleted_at_receiver' => date("Y-m-d H:i:s")
            );
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
    }
	
	
	
	public function update($data,$id) {		
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
    }
	
	public function selectSend($user_id) {		
		return $this->db->where('user_id_from', $user_id)
						->where(array('messages.deleted_at_sender' => NULL))
						->from('messages')
						->join('users', 'messages.user_id_to=users.id')
						->select('messages.id,messages.subject,messages.content,messages.read,messages.created_at, users.name,users.surname')
						->get()->result();
    }
	public function selectReceived($user_id) {		
		return $this->db->where('user_id_to', $user_id)
						->where(array('messages.deleted_at_receiver' => NULL))
						->from('messages')
						->join('users', 'messages.user_id_to=users.id')
						->select('messages.id,messages.subject,messages.content,messages.read,messages.created_at, users.name,users.surname')
						->get()->result();
    }
	
}

?>