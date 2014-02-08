<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Settings extends DataMapper {
	var $table = "settings";
	 function Settings()
    {
        parent::DataMapper();
    }
	public function getSettigns()
	{
		$s = new Settings();
       	$s->not_like('groupname', 'version')->select('id,varname,vartitle,groupname,value,type')->get();
       	return $s;
	}
}