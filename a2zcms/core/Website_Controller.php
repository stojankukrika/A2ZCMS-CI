<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Website_Controller extends MY_Controller
{
	public $ci;
    function __construct()
    {
        parent::__construct();
		
    	$this->load->config('a2zcms');
    	$installed = $this->config->item('installed');
		if($installed!='true')
		{
			$this->load->helper('url');
			redirect('/install');
		}
		else {
			$varname = array('offline', 'metadesc', 'metakey','metaauthor','title',
							'copyright','analytics','dateformat','timeformat','searchcode','sitetheme');
			$this->db->where_in('varname',$varname);
			$query = $this->db->from('settings')->get();
			foreach ($query->result() as $row)
			{
				$this->session->set_userdata($row->varname,$row->value);
			}
			if($this->session->userdata('offline')==1)
			{
				header('Location: '. base_url().'/offline');
				exit ;
			}

		}
    }
}