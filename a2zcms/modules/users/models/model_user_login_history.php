<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_user_login_history extends CI_Model {
	
    function __construct()
	{
		parent::__construct();
	}
	public function select($id) {		
		return $this->db->where('id', $id)->get('user_login_historys')->first_row();
    }
	
	public function insert($data) {		
		$this->db->insert('users', $data);
		return $this -> db -> insert_id();
    }
	
	
	public function total_rows_user($user_id) {
        return $this->db->where(array('u.deleted_at' => NULL))
        				->where('user_id',$user_id)
						->count_all('user_login_historys');
    }
	
    public function fetch_paging_user($limit, $start,$user_id) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('u.deleted_at' => NULL))
        				->where('user_id',$user_id)
        				->get('user_login_historys');
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	
}

?>