<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_user extends CI_Model {
	
    function __construct()
	{
		parent::__construct();
	}
	public function select($id) {		
		return $this->db->where('id', $id)->get('users')->first_row();
    }
	public function selectuser($username)
	{
		return $this->db->where('username', $username)
        			->or_where('email', $username)->get('users')->first_row();
	}
	
	public function insert($data) {		
		$this->db->insert('users', $data);
		return $this -> db -> insert_id();
    }	
	public function inserthistory($data) {		
		$this->db->insert('user_login_historys', $data);
    }
	
	public function total_rows() {
        return $this->db->where(array('deleted_at' => NULL))->count_all("users");
    }
	
    public function fetch_paging($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('deleted_at' => NULL))->get("users");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function total_rows_role($id_role) {
        return $this->db->where(array('u.deleted_at' => NULL))
        				->where('role_id',$id_role)
        				->from("users u")
						->join('assigned_roles ar','u.id = ar.user_id')
						->count_all();
    }
	
    public function fetch_paging_role($limit, $start,$id_role) {
        $this->db->limit($limit, $start);
        $query = $this->db->where(array('u.deleted_at' => NULL))
        				->where('role_id',$id_role)
        				->from("users u")
						->join('assigned_roles ar','u.id = ar.user_id')
        				->get();
 
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
		$this->db->update('users', $data);
    }
	
	function login($username,$password)
    {
        $u = $this->db->where('username', $username)
        			->or_where('email', $username)->get('users')->first_row();
		if ($u->password != $this->encrypt($password))
        {
        	return FALSE;
        }
        else
        {
        	$this->inserthistory(array('created_at'=> date("Y-m-d H:i:s"),'updated_at'=> date("Y-m-d H:i:s"),'user_id'=> $u->id));
            return TRUE;
        }
    }
  	function encrypt($field)
    {
        if (!empty($field))
        {
        	$ci = get_instance();
			$ci->load->library('hash');

            return $ci->hash->make($field);
        }
		return "";
    }
	
}

?>