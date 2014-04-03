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
		if($this->session->userdata('lang')==""){
			$this->session->set_userdata('lang',DEF_LANG);
        }
		$staticLang = $this->uri->segment(1);
		$lang = valid_lang($staticLang) ? $staticLang : ($this->input->get('lang') != "" ? $this->input->get('lang') : $this->session->userdata('lang'));
		if (valid_lang($lang)) {
			$this->lang->load($lang, 'a2zcms');
			$this->session->set_userdata('lang', $lang);
			$_SESSION['lang'] = $lang;
		} else {			
			$this->lang->load(DEF_LANG, 'a2zcms');
			$_SESSION['lang'] = DEF_LANG;
		}
		
		$this->load->helper('url');
		if(!defined('ASSETS_PATH')){
			  define('ASSETS_PATH', base_url('/data/assets/site'));
    	}
		if(!defined('FLAG_PATH')){
			  define('FLAG_PATH', base_url('/data/assets/flags'));
    	}
		if(!defined('ASSETS_PATH_FULL')){
			  define('ASSETS_PATH_FULL', FCPATH.'/data/assets/site');
    	}  		  
		if(!defined('ASSETS_PATH_ADMIN')){
        	define('ASSETS_PATH_ADMIN', base_url('/data/assets/admin'));
		}
		if(!defined('DATA_PATH')){
			  define('DATA_PATH', FCPATH.'/data');
    	}
     }	
}
