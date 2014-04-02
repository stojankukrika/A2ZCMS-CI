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
		if( ! isset($_SESSION['lang'])){
            $_SESSION['lang'] = DEF_LANG;
        }
		
		$get_lang = $this->input->get('lang');
		
		$staticLang = $this->uri->segment(1);
		$lang = valid_lang($staticLang) ? $staticLang : ($this->input->get('lang') != "" ? $this->input->get('lang') : $_SESSION['lang']);

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
	public function change_uilang()
	{
		$old_lang = @$_SESSION['lang'];
		$lang = $this->uri->segment(3);
		if (!valid_lang($lang)) {
			$lang = DEF_LANG;
		}
		$this->session->set_userdata('lang', $lang);
		$_SESSION['lang'] = $lang;
	
		$redirect = $this->input->get('return') ? $this->input->get('return') : $_SERVER['HTTP_REFERER'];
		redirect($redirect);
	}
}
