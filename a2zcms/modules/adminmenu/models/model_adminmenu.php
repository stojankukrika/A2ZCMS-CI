<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_adminmenu extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function menu_admin(){

		$mainadminmenu = $this->db->select('an.id, p.title, an.icon, p.name as url, an.order')
				->from('admin_navigations an')
				->join('plugins p','p.id=an.plugin_id')
				->order_by('ISNULL(an.order), an.order','ASC')
				->where(array('an.deleted_at' => NULL))->get()->result();
		
		foreach ($mainadminmenu as $item) {
			$mainadminsubmenu = $this->db->select('id,admin_navigation_id,title,icon,  url, order')
					->where(array('deleted_at' => NULL))
					->where('admin_navigation_id',$item->id)
					->order_by("order", "asc")
					->order_by("admin_navigation_id", "asc")
					->get('admin_subnavigations')->result();
					if(!empty($mainadminsubmenu)){
						$item->adminsubmenu = $mainadminsubmenu;
					}			
		}	
		return array('mainadminmenu' =>$mainadminmenu);
	}		
}