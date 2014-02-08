<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";


class MY_Controller extends MX_Controller
{
	 function __construct()
	 {
	  	parent::__construct();	
		
		$this->load->helper('url');
		if(!defined('ASSETS_PATH')){
			  define('ASSETS_PATH', base_url('/data/assets/site'));
    	}
		if(!defined('ASSETS_PATH_FULL')){
			  define('ASSETS_PATH_FULL', FCPATH.'/data/assets/site');
    	}  		  
		if(!defined('ASSETS_PATH_ADMIN')){
        	define('ASSETS_PATH_ADMIN', base_url('/data/assets/admin'));
		}
     }
}
