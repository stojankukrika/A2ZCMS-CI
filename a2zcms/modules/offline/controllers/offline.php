<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Offline extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
			$varname = array('offline', 'offlinemessage');
			$offline = "";
			$offlinemessage = "";
			$this->db->where_in('varname',$varname);
			$query = $this->db->from('settings')->get();
			foreach ($query->result() as $row)
			{
				if($row->varname=="offline")
				$offline = $row->value;
				
				if($row->varname=="offlinemessage")
				$offlinemessage = $row->value;
			}
			$this->load->helper('url');
			if($offline=="Yes")
			{
				echo $offlinemessage;
				die();
			}
			else {				
				redirect('');
			}
	}

}