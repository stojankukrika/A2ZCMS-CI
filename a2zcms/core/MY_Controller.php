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
     }
}
