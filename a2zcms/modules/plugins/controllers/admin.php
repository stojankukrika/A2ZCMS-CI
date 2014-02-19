<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Admin extends Administrator_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
        $plugin = $this->db->from('plugins p')
				->join('admin_navigations an','p.id=an.plugin_id','left')
        		->where('p.deleted_at', NULL)
				->where('an.deleted_at', NULL)
				->order_by('ISNULL(an.order), an.order','ASC')
				->select('p.id,p.name,p.title,p.can_uninstall,p.created_at')
				->get()->result();
				
		$temp = array();
		foreach ($plugin as $item) {
			$temp[]=$item->name;
		}
			
		foreach (glob( FCPATH.'/a2zcms/modules' . '/*', GLOB_ONLYDIR) as $dir) {
			$dir = str_replace(FCPATH.'/a2zcms/modules/', '', $dir);
			if(!in_array($dir,$temp) && $dir!='install' && $dir!='testmodule')
			$plugin[] =(object) array('name' => $dir, 'id'=>0,
			'title' => ucfirst($dir), 'created_at' => '', 'can_uninstall' =>0, 'not_installed'=>TRUE);
		}
			
        $data['content'] = array(
            'navigation' => $plugin
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function plugin_reorder()
	{
		$list = $this->input->get('list');
		$items = explode(",", $list);
		$order = 1;
		foreach ($items as $value) {
			if ($value != '') {

				$data = array(
               			'order' => $order,
               			'updated_at' => date("Y-m-d H:i:s")
           		);
				$this->db->where('plugin_id', $value);
				$this->db->update('admin_navigations', $data); 
				echo $this->db->last_query();			
				$order++;
			}
		};
	}
	
	function install($id)
	{
		$data['view'] = 'install';
		$data['content'] = array('pluginid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('pluginid', "Plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('pluginid');
			
        }
	}
	function uninstall($id)
	{
		$data['view'] = 'uninstall';
		$data['content'] = array('pluginid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('pluginid', "Plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('pluginid');
			
        }
	}
	

}