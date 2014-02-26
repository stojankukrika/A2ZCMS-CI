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
			$varname = array('offline', 'metadesc','offlinemessage','metakey','metaauthor','title', 'email',
							'copyright','analytics','dateformat','timeformat','searchcode','sitetheme');
			$this->db->where_in('varname',$varname);
			$query = $this->db->from('settings')->get();
			foreach ($query->result() as $row)
			{
				$this->session->set_userdata($row->varname,$row->value);
			}
			if($this->session->userdata("dateformat")!="" && $this->session->userdata("timeformat")!="")
			{
				$dateformat = $this->session->userdata("dateformat").$this->session->userdata("timeformat");
			}
			else {
				$dateformat = "d.m.Y h:i A";
			}
			$this->session->set_userdata('datetimeformat',$dateformat);
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
			$page_id = $this->db->select('id')->limit(1)->get('pages')->first_row()->id;
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
				$sidebar_right[] = array('content' => modules::run($item['name'].'/'.$function, $params));
			}
			if($page->sidebar==0){
				$sidebar_left[] = array('content' => modules::run($item['name'].'/'.$function, $params));
			}
		}
		foreach ($function_content as $item2)
		{
			$function2 = isset($item2['function'])?$item2['function']:"";
			$ids = isset($item2['ids'])?$item2['ids']:"";
			$grids = isset($item2['grids'])?$item2['grids']:"";
			$sorts = isset($item2['sorts'])?$item2['sorts']:"";
			$limits = isset($item2['limits'])?$item2['limits']:"";
			$orders = isset($item2['orders'])?$item2['orders']:"";
			$params = isset($item2['params'])?$item2['params']:"";
			
			if(!isset($item2['name']))
			{
				$item2['name'] = 'pages';
			}		
			if($params=="")
			{
				$content[] = array('content' => modules::run($item2['name'].'/'.$function2, $page_id));
			}
			else {
				$content[] = array('content' => modules::run($item2['name'].'/'.$function2, $ids,$grids,$sorts,$limits,$orders));
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
									
								
			foreach ($pluginfunction_content as $key => $items) {
				
				if($items['plugin_function_id']!=""){
					
					$item = $this->db->from('page_plugin_functions')
											->where('param','id')->where('page_id',$page_id)
											->where('plugin_function_id',$items['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$pluginfunction_content[$key]['ids'] = (!empty($item))?$item->value:"";
					$item = $this->db->from('page_plugin_functions')
											->where('param','grid')->where('page_id',$page_id)
											->where('plugin_function_id',$items['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$pluginfunction_content[$key]['grids'] = (!empty($item))?$item->value:"";
					$item =  $this->db->from('page_plugin_functions')
											->where('param','sort')->where('page_id',$page_id)
											->where('plugin_function_id',$items['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$pluginfunction_content[$key]['sorts'] = (!empty($item))?$item->value:"";
					$item =  $this->db->from('page_plugin_functions')
											->where('param','limit')
											->where('page_id',$page_id)
											->where('plugin_function_id',$items['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$pluginfunction_content[$key]['limits'] = (!empty($item))?$item->value:"";
					$item =  $this->db->from('page_plugin_functions')
											->where('param','order')
											->where('page_id',$page_id)
											->where('plugin_function_id',$items['plugin_function_id'])
											->select('value')
											->get()->first_row();
					$pluginfunction_content[$key]['orders'] = (!empty($item))?$item->value:"";
				}
			}
			$pluginfunction_slider = $this->db->from('page_plugin_functions')
								->join('plugin_functions','plugin_functions.id = page_plugin_functions.plugin_function_id','left')
								->join('plugins','plugin_functions.plugin_id = plugins.id','left')
								->where('page_plugin_functions.page_id',$page_id)
								->where('plugin_functions.type','sidebar')
								->where('page_plugin_functions.deleted_at', NULL)
								->where('plugin_functions.deleted_at', NULL)
								->order_by('page_plugin_functions.order','ASC')
								->group_by('plugin_functions.id')
								->select('plugin_functions.id, plugins.name, plugin_functions.title ,plugin_functions.params ,
								plugin_functions.function ,page_plugin_functions.order')
								->get()->result_array();
		return array('pluginfunction_content' => $pluginfunction_content, 'pluginfunction_slider' => $pluginfunction_slider);
	}
	
	public function splitParams($params)
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

	/*method for voting content get id of content,up-down vote and type of content(page,blog,image)*/
	public function contentvote()
	{
		$id = $this->input->post('id');
		$updown = $this->input->post('updown');
		$content = $this->input->post('content');
		$user = $this->session->userdata('user_id');
		$newvalue = 0;
		$exists = $this->db->where('content',$content)
							->where('idcontent',$id)
							->where('user_id',$user)
							->select('id')->get('content_votes');
		
		switch ($content) {
			case 'page':
				$item = $this->db->where('id', '=', $id)->get('pages')->first_row();
				break;
			case 'image':
				$item = $this->db->where('id', '=', $id)->get('gallery_images')->first_row();
				break;
			case 'blog':
				$item = $this->db->where('id', '=', $id)->get('blogs')->first_row();
				break;			
			}
		if($exists->num_rows() == 0 ){
			$this->db->insert('content_votes',array('user_id'=>$user,
														'updown' => $updown,
														'content' => $content,
														'idcontent' => $id,
														'user_id' => $this->session->userdata('user_id'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			
			if($updown=='1')
				{
					$item -> voteup = $item -> voteup + 1;
				}
				else {
					$item -> votedown = $item -> votedown + 1;
				}
				
		$this->db->where('id', $id);		
		$data = array(
               'voteup' => $item -> voteup,
               'votedown' => $item -> voteup,
            	);
				switch ($content) {
					case 'page':
						$this->db->update('pages', $data);
						break;
					case 'image':
						$this->db->update('gallery_images', $data);
						break;
					case 'blog':
						$this->db->update('blogs', $data);
						break;			
					}					
			}
			$newvalue = $item->voteup - $item -> votedown;
					
		return $newvalue;
	}
	
}