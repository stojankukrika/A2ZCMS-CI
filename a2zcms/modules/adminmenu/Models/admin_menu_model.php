<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Admin_menu_model extends CI_Model{
	
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
			$item->adminsubmenu = $mainadminsubmenu;
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