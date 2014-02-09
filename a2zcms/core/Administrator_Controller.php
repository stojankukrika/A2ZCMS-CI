<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrator_Controller extends MY_Controller {
 	public function __construct() {
        parent::__construct();    
				
		if (!$this->session->userdata('admin_logged_in')) {
            redirect('');
        }
			$varname = array('pageitemadmin');
			$this->db->where_in('varname',$varname);
			$query = $this->db->from('settings')->get();
			foreach ($query->result() as $row)
			{
				$this->session->set_userdata($row->varname,$row->value);
			}
    }
}