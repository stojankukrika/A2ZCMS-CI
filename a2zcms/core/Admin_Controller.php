<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
 	public function __construct() {
        parent::__construct();    
		
		$this->load->helper('url');
		if(!defined('ASSETS_PATH_ADMIN')){
        	define('ASSETS_PATH_ADMIN', base_url('/data/assets/admin'));
		}
		    
		if (!$this->session->userdata('is_admin_login')) {
            redirect('admin/home');
        }
    }
}