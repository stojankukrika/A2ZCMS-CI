<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Website_Controller extends MY_Controller
{
	public $ci;
    function __construct()
    {
        parent::__construct();
		
    	$this->load->config('a2zcms');
    	$installed = $this->config->item('installed');
		if($installed!='true')
		{
			$this->load->helper('url');
			redirect('/install');
		}
		else {
			$varname = array('offline', 'metadesc','offlinemessage','metakey','metaauthor','title',
							'copyright','analytics','dateformat','timeformat','searchcode','sitetheme');
			$this->db->where_in('varname',$varname);
			$query = $this->db->from('settings')->get();
			foreach ($query->result() as $row)
			{
				$this->session->set_userdata($row->varname,$row->value);
			}
			if($this->session->userdata('offline')=="Yes")
			{
				header('Location: '. base_url('offline'));
				exit ;
			}
		}
    }
	public function createSiderContent($page_id=0)
	{
		
		if($page_id==0) {
			$page_id = $this->db->select('id')->get('pages')->first_row()->id;
		}
		$page = $this->db->where('id',$page_id)->get('pages')->first_row();
		
		$page_functions = $this->readModulsForPage($page_id);
		
		$function_content = $page_functions['pluginfunction_content'];
		$function_slider = $page_functions['pluginfunction_slider'];		

		$sidebar_right = array(); 
		$sidebar_left = array(); 
		$content = array();		
		
		foreach ($function_slider as $item)
		{
			if(!isset($item['name']))
			{
				$item['name'] = 'pages';
			}
			$function = $item['function'];
			$params = $item['params'];
			if($page->sidebar==1){
				$this->load->module($item['name']);
				$sidebar_right[] = array('content' =>$this->$item['name']->$function($params));
			}
			if($page->sidebar==0){
				$this->load->module($item['name']);
				$sidebar_left[] = array('content' =>$this->$item['name']->$function($params));
			}
		}
		foreach ($function_content as $item2)
		{
			$function2 = isset($item['function'])?$item['function']:"";
			$ids = isset($item['ids'])?$item['ids']:"";
			$grids = isset($item['grids'])?$item['grids']:"";
			$sorts = isset($item['sorts'])?$item['sorts']:"";
			$limits = isset($item['limits'])?$item['limits']:"";
			$orders = isset($item['orders'])?$item['orders']:"";
			$params = isset($item['params'])?$item['params']:"";
			
			if(!isset($item['name']))
			{
				$item['name'] = 'pages';
			}			
			if($params=="")
			{
				$this->load->module($item['name']);
				$content[] = array('content' =>$this->$item['name']->$function($page_id));
			}
			else {
				$this->load->module($item['name']);
				$content[] = array('content' =>$this->$item['name']->$function($ids,$grids,$sorts,$limits,$orders));
			}
		}
		return $pagecontent = array('sidebar_right' => $sidebar_right, 'sidebar_left'=>$sidebar_left, 'content'=>$content);	
	}
	public function readModulsForPage($page_id)
	{
		$pluginfunction_content = $this->db->from('page_plugin_functions')
									->join('plugin_functions','plugin_functions.id = page_plugin_functions.plugin_function_id','left')
									->join('plugins', 'plugins.id = plugin_functions.plugin_id','left')
									->where('page_plugin_functions.page_id',$page_id)
									->where('plugin_functions.type','content')
									->where('page_plugin_functions.deleted_at', NULL)
									->where('plugin_functions.deleted_at', NULL)
									->order_by('page_plugin_functions.order','ASC')
									->group_by('plugin_functions.id')
									->select('plugin_functions.id, page_plugin_functions.plugin_function_id,
									plugin_functions.title ,plugins.name, page_plugin_functions.order ,plugins.function_id ,
									plugin_functions.function ,plugin_functions.params ,plugins.function_grid')
									->get()->result_array();
			foreach ($pluginfunction_content as $key => $value) {
				if($value['plugin_function_id']!=""){
					
					$item = $this->db->from('page_plugin_functions')
											->where('param','id')->where('page_id',$page_id)
											->where('plugin_function_id',$value['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$value['ids'] = (!empty($item)?$item->value:"");
					$item = $this->db->from('page_plugin_functions')
											->where('param','grid')->where('page_id',$page_id)
											->where('plugin_function_id',$value['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$value['grids'] = (!empty($item)?$item->value:"");
					$item =  $this->db->from('page_plugin_functions')
											->where('param','sort')->where('page_id',$page_id)
											->where('plugin_function_id',$value['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$value['sorts'] = (!empty($item)?$item->value:"");
					$item =  $this->db->from('page_plugin_functions')
											->where('param','limit')
											->where('page_id',$page_id)
											->where('plugin_function_id',$value['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$value['limits'] = (!empty($item)?$item->value:"");
					$item =  $this->db->from('page_plugin_functions')
											->where('param','order')
											->where('page_id',$page_id)
											->where('plugin_function_id',$value['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$value['orders'] = (!empty($item)?$item->value:"");
				}
			}
				
			$pluginfunction_slider = $this->db->from('page_plugin_functions')
								->join('plugin_functions','plugin_functions.id = page_plugin_functions.plugin_function_id','left')
								->where('page_plugin_functions.page_id',$page_id)
								->where('plugin_functions.type','sidebar')
								->where('page_plugin_functions.deleted_at', NULL)
								->where('plugin_functions.deleted_at', NULL)
								->order_by('page_plugin_functions.order','ASC')
								->group_by('plugin_functions.id')
								->select('plugin_functions.id, plugin_functions.title ,plugin_functions.params ,
								plugin_functions.function ,page_plugin_functions.order')
								->get()->result_array();
	
		return $arrayName = array('pluginfunction_content' => $pluginfunction_content, 'pluginfunction_slider' => $pluginfunction_slider);
	}
	
	private function splitParams($params)
	{
		$return = array();
		$params = explode(';', $params);
		foreach ($params as $param) {
			if($param!=""){
				$param = explode(':', $param);
				$return[$param[0]] = $param[1];
				}
			}
		return $return;	
	}
	
}