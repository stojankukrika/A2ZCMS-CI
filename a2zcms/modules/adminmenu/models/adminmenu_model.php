<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Adminmenu_model extends CI_Model{
	
	function menu_admin(){

		$mainadminmenu = new Admin_navigation();
		$mainadminmenu->select('id, title, icon, url, order')
					->where(array('deleted_at' => NULL))
					->order_by("order", "asc")
					->get();
		foreach ($mainadminmenu as $item) {
			$mainadminsubmenu = new Admin_subnavigation();
			$mainadminsubmenu->select('id,admin_navigation_id,title,icon,  url, order')
					->where(array('deleted_at' => NULL))
					->where('admin_navigation_id',$item->id)
					->order_by("order", "asc")
					->order_by("admin_navigation_id", "asc")
					->get();
					if(!empty($mainadminsubmenu->id)){
						$item->adminsubmenu = $mainadminsubmenu;
					}
			
		}
		
				
		return array('mainadminmenu' =>$mainadminmenu);
	}		
}

class Admin_navigation extends DataMapper{
	var $table = "admin_navigations";
}
class Admin_subnavigation extends DataMapper{
	var $table = "admin_subnavigations";
}

?>