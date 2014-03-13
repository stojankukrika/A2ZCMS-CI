<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Model_plugin extends CI_Model {

	
	function __construct()
	{
		parent::__construct();
	}
	
	public function getall()
	{
		return $this->db->from('plugins p')
				->join('admin_navigations an','p.id=an.plugin_id')
        		->where('p.deleted_at', NULL)
				->where('an.deleted_at', NULL)
				->order_by('ISNULL(an.order), an.order','ASC')
				->select('p.id,p.name,p.title,p.can_uninstall,p.created_at,p.pluginversion')
				->get()->result();
	}
	
	public function update($data,$id) {
		
		$this->db->where('plugin_id', $id);
		$this->db->update('admin_navigations', $data);
    }
	
	function menu_admin(){

		return $mainadminmenu = $this->db->select('an.id, p.title, an.background_color,an.icon, p.name, an.order')
				->from('admin_navigations an')
				->join('plugins p','p.id=an.plugin_id')
				->order_by('ISNULL(an.order), an.order','ASC')
				->where(array('an.deleted_at' => NULL))->get()->result();
	}	
	
}