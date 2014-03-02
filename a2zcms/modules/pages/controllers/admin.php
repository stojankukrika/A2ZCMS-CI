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
		$this->load->model(array("Model_navigation_group","Model_navigation_link","Model_page_plugin_function",
								"Model_page","Model_plugin_function","Model_plugin"));
	}
	
	/*navigation group*/
	function navigationgroups(){
		if (!$this->session->userdata("manage_navigation_groups")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigationgroup/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
		
        $navigationgroup = $this->Model_navigation_group->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
 
        $pagination_config = array(
            'base_url' => site_url('admin/pages/navigationgroups/'),
            'first_url' => site_url('admin/pages/navigationgroups/0'),
            'total_rows' => $this->Model_navigation_group->total_rows(),
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 4,
           	'full_tag_open' => '<ul class="pagination">',
			'first_tag_open' => '<li>',
			'first_link' => '<span class="icon-fast-backward"></span>',
		    'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_link' => '<span class="icon-fast-forward"></span>',
			'last_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_link' => '<span class="icon-step-forward"></span>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_link' => '<span class="icon-step-backward"></span>',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'full_tag_close' => '</ul>',
        );
		
		
        $this->pagination->initialize($pagination_config);
 
        $data['content'] = array(
            'pagination' => $this->pagination,
            'navigationgroup' => $navigationgroup
        );
 
        $this->load->view('adminpage', $data);
	}
	function navigationgroups_create($id=0)
	{
		if (!$this->session->userdata("manage_navigation_groups")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigationgroup/create_edit';

		$navigationgroup_edit = "";
		
		if($id>0)
		{
			$navigationgroup_edit = $this->Model_navigation_group->select($id);			
		}
		
		$data['content'] = array('navigationgroup_edit' => $navigationgroup_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	if($id==0){
				$this->Model_navigation_group->insert(array('title'=>$this->input->post('title'),
														'slug' => url_title($this->input->post('title'), 'dash', true),
														'showmenu' => $this->input->post('showmenu'),
														'showfooter' => $this->input->post('showfooter'),
														'showsidebar' => $this->input->post('showsidebar'),														
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_navigation_group->update(array('title'=>$this->input->post('title'),
							'slug' => url_title($this->input->post('title'), 'dash', true),
							'showmenu' => $this->input->post('showmenu'),
							'showfooter' => $this->input->post('showfooter'),
							'showsidebar' =>$this->input->post('showsidebar'),
							'updated_at'=>date("Y-m-d H:i:s")),$id);
			}
        }
    }
	function navigationgroups_delete($id)
	{
		if (!$this->session->userdata("manage_navigation_groups")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigationgroup/delete';
		$data['content'] = array('navigationgroupid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('navigationgroupid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('navigationgroupid');
			$this->Model_navigation_group->delete($id);
        }
	}
	
	/*Navigation list*/
	function navigation(){
		if (!$this->session->userdata("manage_navigation")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigation/dashboard';
		
		$navigation = $this->Model_navigation_link->getall();
		
        $data['content'] = array(
            'navigation' => $navigation
        );
 
        $this->load->view('adminpage', $data);
	}
	function navigation_reorder()
	{
		if (!$this->session->userdata("manage_navigation")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$list = $this->input->get('list');
		$items = explode(",", $list);
		$order = 1;
		foreach ($items as $value) {
			if ($value != '') {
				
				$this->Model_navigation_link->update(array('position'=>$order,
													'updated_at' => date("Y-m-d H:i:s")),$id);

				$order++;
			}
		}
	}
	function navigation_create($id=0)
	{
		if (!$this->session->userdata("manage_navigation")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigation/create_edit';

		$navigation_edit = "";
		$navigation_parent = "";
		
		$pagelist = $this->Model_page->getall();
		
		$navigationGroupList = $this->Model_navigation_group->getall();
		
		if($id>0)
		{
			$navigation_edit = $this->Model_navigation_link->select($id);
			
			$navigation_parent = $this->Model_navigation_link->selectallparent($id);
				
		}
		else {
			$navigation_parent = $this->Model_navigation_link->getall();
		}
		
		$data['content'] = array('navigation_edit' => $navigation_edit,
								'pagelist' => $pagelist,
								'navigationGroupList' => $navigationGroupList,
								'navigation_parent' => $navigation_parent);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
		$this->form_validation->set_rules('link_type', "Link type", 'required');
		$this->form_validation->set_rules('target', "Target", 'required');
		
	   	if ($this->form_validation->run() == TRUE)
        {
			if($id==0){
        		$this->Model_navigation_link->insert(array('title'=>$this->input->post('title'),
														'link_type' => $this->session->userdata('link_type'),
														'parent' => ($this->input->post('parent') != '') ? $this->input->post('parent') : NULL,
														'page_id' => $this->input->post('page_id'),
														'url' => $this->input->post('url'),														
														'uri' => $this->input->post('uri'),	
														'navigation_group_id' => $this->input->post('navigation_group_id'),	
														'target' => $this->input->post('target'),	
														'class' => $this->input->post('class'),																										
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				
				$this->Model_navigation_link->update(array('title'=>$this->input->post('title'), 
													'link_type'=>$this->input->post('link_type'), 
													'parent'=>($this->input->post('parent') != '') ? $this->input->post('parent') : NULL, 
													'page_id'=>$this->input->post('page_id'), 
													'url'=>$this->input->post('url'), 
													'uri'=>$this->input->post('uri'), 
													'navigation_group_id'=>$this->input->post('navigation_group_id'), 
													'target'=>$this->input->post('target'), 
													'class'=>$this->input->post('class'),							
													'updated_at'=>date("Y-m-d H:i:s")),$id);
			}
        }
    }
	function navigation_delete($id)
	{
		if (!$this->session->userdata("manage_navigation")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'navigation/delete';
		$data['content'] = array('navigationlinkid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('navigationlinkid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('navigationlinkid');
			
			$this->Model_navigation_link->delete($id);
        }
	}
	
	/*Pages*/
	function index(){
		if (!$this->session->userdata("manage_pages")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
		$page = $this->Model_page->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
		 
        $pagination_config = array(
            'base_url' => site_url('admin/pages/index/'),
            'first_url' => site_url('admin/pages/index/0'),
            'total_rows' => $this->Model_page->total_rows(),
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 4,
           	'full_tag_open' => '<ul class="pagination">',
			'first_tag_open' => '<li>',
			'first_link' => '<span class="icon-fast-backward"></span>',
		    'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_link' => '<span class="icon-fast-forward"></span>',
			'last_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_link' => '<span class="icon-step-forward"></span>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_link' => '<span class="icon-step-backward"></span>',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'full_tag_close' => '</ul>',
        );
				
        $this->pagination->initialize($pagination_config);
 
        $data['content'] = array(
            'pagination' => $this->pagination,
            'page' => $page
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		if (!$this->session->userdata("manage_pages")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'create_edit';

		$page_edit = $pluginfunction_content_all = $pluginfunction_slider_all = "";
						
		if($id<=0){
			$pluginfunction_content = $this->Model_page_plugin_function->contentpluginfunction();
			
			foreach ($pluginfunction_content as $item) {
				$function_id = (isset($item->function_id))?$item->function_id:NULL;
				$function_grid = (isset($item->function_grid))?$item->function_grid:NULL;
				if($function_id!=NULL){
					$item->function_id = modules::run($item->name.'/'.$function_id);
				}
				if($function_grid!=NULL){
					$item->function_grid = modules::run($item->name.'/'.$function_grid);
				}
			}	
			$pluginfunction_slider = $this->Model_page_plugin_function->sidepluginfunction();
		}
		else
		{
			$page_edit = $this->Model_page->select($id);

			/*select content plugins that added to page*/
			
			
			$pluginfunction_content = $this->Model_page_plugin_function->contentpluginfunctionpage($id);
			$pluginfunction_content_all =  $this->Model_page_plugin_function->contentpluginfunction();
			 /*add to view other content plugins that not in page*/
			$temp = array();
				foreach ($pluginfunction_content as $item) {
					if(!empty($item->function_id))
					$temp[]=$item->function_id;
				}
			foreach ($pluginfunction_content_all as $item) {
				if(!empty($item->function_id) && !in_array($item->function_id,$temp))
				$pluginfunction_content[]=$item;
			}		
			/*get other values for selected plugins*/
			foreach ($pluginfunction_content as $item) {
				$function_id = $function_grid= "";
				if(isset($item->function_id)){
					$function_id = $item->function_id;
				}
				if(isset($item->function_grid)){
					$function_grid = $item->function_grid;
				}
				if(isset($item->plugin_function_id)){					
					$temp1 =  $this->Model_page_plugin_function->contentparamitem('id',$id,$item->plugin_function_id);
					if(!empty($temp1))
					$item->ids = $temp1->value;
					$temp1 =  $this->Model_page_plugin_function->contentparamitem('grid',$id,$item->plugin_function_id);
					if(!empty($temp1))
					$item->grids = $temp1->value;
					$temp1 =  $this->Model_page_plugin_function->contentparamitem('sort',$id,$item->plugin_function_id);
					if(!empty($temp1))
					$item->sorts = $temp1->value;
					$temp1 =  $this->Model_page_plugin_function->contentparamitem('limit',$id,$item->plugin_function_id);
					if(!empty($temp1))
					$item->limits = $temp1->value;
					$temp1 =  $this->Model_page_plugin_function->contentparamitem('order',$id,$item->plugin_function_id);
					if(!empty($temp1))
					$item->orders = $temp1->value;
					}
					if($function_id!=NULL){
						$item->function_id = modules::run($item->name.'/'.$function_id);
					}
					if($function_grid!=NULL){
						$item->function_grid = modules::run($item->name.'/'.$function_grid);
					}
			}
			/*select sidebar plugins*/
			
			$pluginfunction_slider = $this->Model_page_plugin_function->sidepluginfunctionpage($id);
													
			$pluginfunction_slider_all =  $this->Model_page_plugin_function->sidepluginfunction();
			
			 /*add not added sidebar plugins*/
			$temp = array();
			foreach ($pluginfunction_slider as $item) {
				$temp[]=$item->id;
			}
			foreach ($pluginfunction_slider_all as $item) {
				if(!in_array($item->id,$temp))
				$pluginfunction_slider[]=$item;
			}
		
		}
		
		$data['content'] = array('page_edit' => $page_edit,
								'pluginfunction_content'=> $pluginfunction_content,
								'pluginfunction_slider' => $pluginfunction_slider);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {        	
			if($id==0){
				$id = $this->Model_page->insert(array('title'=>$this->input->post('title'),
												'slug' => url_title( $this->input->post('title'), 'dash', true),
												'meta_title' => $this->input->post('meta_title'),
												'meta_description' => $this->input->post('meta_description'),
												'meta_keywords' => $this->input->post('meta_keywords'),	
												'page_css' => $this->input->post('page_css'),	
												'page_javascript' => $this->input->post('page_javascript'),	
												'sidebar' => $this->input->post('sidebar'),	
												'showtitle' => $this->input->post('showtitle'),	
												'showvote' => $this->input->post('showvote'),	
												'showdate' => $this->input->post('showdate'),	
												'password' => $this->input->post('password'),	
												'tags' => $this->input->post('tags'),	
												'showtags' => $this->input->post('showtags'),	
												'content' => $this->input->post('content'),	
												'status' => $this->input->post('status'),																									
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
			}
			else {				
				$this->Model_page->update(array('title'=>$this->input->post('title'),
												'slug' => url_title( $this->input->post('title'), 'dash', true),
												'meta_title' => $this->input->post('meta_title'),
												'meta_description' => $this->input->post('meta_description'),
												'meta_keywords' => $this->input->post('meta_keywords'),	
												'page_css' => $this->input->post('page_css'),	
												'page_javascript' => $this->input->post('page_javascript'),	
												'sidebar' => $this->input->post('sidebar'),	
												'showtitle' => $this->input->post('showtitle'),	
												'showvote' => $this->input->post('showvote'),	
												'showdate' => $this->input->post('showdate'),	
												'password' => $this->input->post('password'),	
												'tags' => $this->input->post('tags'),	
												'showtags' => $this->input->post('showtags'),	
												'content' => $this->input->post('content'),	
												'status' => $this->input->post('status'),																									
												'updated_at' => date("Y-m-d H:i:s")),$id);
							
				$this->Model_page_plugin_function->delete($id);
			
			}
			$file='';
			if(!empty($_FILES['image']['name'])){
				$filename = $_FILES['image']['name'];
				$file = sha1($filename.time()).'.'.pathinfo($filename, PATHINFO_EXTENSION);
				$config['file_name'] = $file;
				$config['upload_path'] = DATA_PATH.'/page/';
				$config['allowed_types'] = 'gif|jpg|png';
				$this->load->library('upload', $config);
				$this->upload->do_upload('image');
				
				$config_manip['source_image'] = $config['upload_path'].$file;
				$config_manip['new_image'] = DATA_PATH.'/page/thumbs';
	            $config_manip['maintain_ratio'] = TRUE;
			    $config_manip['create_thumb'] = TRUE;
			    $config_manip['width'] = 150;
			    $config_manip['quality'] = 100;
				$config_manip['height'] = 100;
			    $config_manip['thumb_marker'] = '_thumb';
	            $this->load->library('image_lib', $config_manip);
	            $this->image_lib->resize();
				
				$this->Model_page->update(array('image'=>$file),$id);			
			}
			
			$pagesidebar = ($this->input->post('pagesidebar')!="")?$this->input->post('pagesidebar'):"";
			$pagecontentorder = $this->input->post('pagecontentorder');
			$pagecontent = $this->input->post('pagecontent');
			
			$this->SaveData($pagesidebar,$pagecontentorder, $pagecontent,$id);
        }
		
    }
	function delete($id)
	{
		if (!$this->session->userdata("manage_pages")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['view'] = 'delete';
		$data['content'] = array('pageid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('pageid', "Page", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('pageid');
			$this->Model_page->delete($id);
        }
	}
	
	function change($id)
	{
		if (!$this->session->userdata("manage_pages")){
			redirect($_SERVER['HTTP_REFERER']);
		}		
		$page =$this->Model_page->select($id);
		$this->Model_page->update(array('status'=>($page -> status + 1) % 2,
											'updated_at'=>date("Y-m-d H:i:s")),$id);
		
		return redirect(base_url('admin/pages'));
		
	}
	function saveData($pagesidebar="",$pagecontentorder,$pagecontent,$page_id)
	{
		if (!$this->session->userdata("manage_pages")){
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($pagesidebar!=""){
				$order = 1;
				foreach ($pagesidebar as $value) {
					$plugin_function = $this->Model_plugin_function->select($value);
					$params = $plugin_function->params;
					if($params!=NULL){
						$params = explode(';', $params);
						foreach ($params as $parameter) {
							if($parameter!=""){
								$parameter = explode(':', $parameter);
								$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order,
															'param' => $parameter['0'],
															'type' => (strstr($parameter['1'], ','))?'array':(is_int($parameter['1']))?'int':'string',
															'value' => $parameter['1'],	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
							}
						}
					}	
				else {
					$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order,
															'page_id' => $page_id,
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));															
					}				
					$order ++;
				}
			}
			$order2 = 1;
			$items = explode(',', $pagecontentorder);
				foreach ($items as $value) {
					$params = "";
					if(!empty($pagecontent[$value]['id'])){
						foreach ($pagecontent[$value]['id'] as $value2) {
							$params .= $value2.",";
						}
						$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => 'id',
															'type' => 'array',
															'page_id' => $page_id,
															'value' => rtrim($params, ","),	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
												
					}
					if(!empty($pagecontent[$value]['grid'])){
						foreach ($pagecontent[$value]['grid'] as $value2) {
							$params .= $value2.",";
						}
					$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => 'grid',
															'type' => 'array',
															'page_id' => $page_id,
															'value' => rtrim($params, ","),	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
					}
					if(isset($pagecontent[$value]['sort'])){
						$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => 'sort',
															'type' => 'string',
															'page_id' => $page_id,
															'value' => $pagecontent[$value]['sort'],	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
					}
					if(isset($pagecontent[$value]['order'])){
						$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => 'order',
															'type' => 'string',
															'page_id' => $page_id,
															'value' => $pagecontent[$value]['order'],	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
					}
					if(isset($pagecontent[$value]['limit'])){
						$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => 'limit',
															'type' => 'int',
															'page_id' => $page_id,
															'value' => $pagecontent[$value]['limit'],	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
					}
					if(empty($pagecontent[$value]['id']) && empty($pagecontent[$value]['grid']) && 
						!isset($pagecontent[$value]['sort']) && !isset($pagecontent[$value]['order']) &&
						!isset($pagecontent[$value]['limit']))
						{
							$this->Model_page_plugin_function->insert(array('plugin_function_id'=>$value,
															'order' => $order2,
															'param' => '',
															'type' => '',
															'page_id' => $page_id,
															'value' => '',	
															'page_id' => $page_id,	
															'updated_at' => date("Y-m-d H:i:s"),
															'created_at' => date("Y-m-d H:i:s")));
						}
					
					$order2 ++;
				}
	}
}