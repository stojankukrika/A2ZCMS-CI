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
	
	/*navigation group*/
	function navigationgroups(){
		$data['view'] = 'navigationgroup/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $navigationgroup = new NavigationGroup();
        $navigationgroup->where(array('deleted_at' => NULL))
			->select('id,title,slug,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
		
        if ($offset > $navigationgroup->paged->total_rows) {
            $offset = floor($navigationgroup->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/pages/navigationgroups/'),
            'first_url' => site_url('admin/pages/navigationgroups/0'),
            'total_rows' => $navigationgroup->paged->total_rows,
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
            'navigationgroup' => $navigationgroup,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	function navigationgroups_create($id=0)
	{
		$data['view'] = 'navigationgroup/create_edit';

		$navigationgroup_edit = "";
		
		if($id>0)
		{
			$navigationgroup_edit = new NavigationGroup();
			$navigationgroup_edit->select('id,title,slug,showmenu,showfooter,showsidebar,created_at')
			->where('id',$id)->get();			
		}
		
		$data['content'] = array('navigationgroup_edit' => $navigationgroup_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$navigationgroup = new NavigationGroup();
			if($id==0){
				$navigationgroup->title = $this->input->post('title');
				$navigationgroup->slug = url_title($this->input->post('title'), 'dash', true);
				$navigationgroup->showmenu = $this->input->post('showmenu');
				$navigationgroup->showfooter = $this->input->post('showfooter');
				$navigationgroup->showsidebar = $this->input->post('showsidebar');
				$navigationgroup->updated_at = date("Y-m-d H:i:s");										
				$navigationgroup->created_at = date("Y-m-d H:i:s");		
				$navigationgroup -> save();
			}
			else {				
				$navigationgroup->where('id', $id)->update(array('title'=>$this->input->post('title'),
							'slug' => url_title($this->input->post('title'), 'dash', true),
							'showmenu' => $this->input->post('showmenu'),
							'showfooter' => $this->input->post('showfooter'),
							'showsidebar' =>$this->input->post('showsidebar'),
							'updated_at'=>date("Y-m-d H:i:s")));
			}
        }
    }
	function navigationgroups_delete($id)
	{
		$data['view'] = 'navigationgroup/delete';
		$data['content'] = array('navigationgroupid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('navigationgroupid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('navigationgroupid');
			
			$navigationgroup = new NavigationGroup();
			$navigationgroup->where('id', $id)
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	/*Navigation list*/
	function navigation(){
		$data['view'] = 'navigation/dashboard';
		
        $navigation = new NavigationLink();
        $navigation->where(array('deleted_at' => NULL))
			->select('id,title,link_type,page_id,navigation_group_id,created_at')
			->order_by('position','ASC')
			->get();
		
		foreach ($navigation as $item) {
			
 			$navigationgroup = new NavigationGroup();		
			$navigationgroup->where('id', $item->page_id)->select('title')->get();
			$item->navigationgroup = $navigationgroup->title;
			
			$page = new Page();		
			$page->where('id', $item->navigation_group_id)->select('title')->get();
			$item->page = $page->title;
			
		 }
        $data['content'] = array(
            'navigation' => $navigation
        );
 
        $this->load->view('adminpage', $data);
	}
	function navigation_reorder()
	{
		$list = $this->input->get('list');
		$items = explode(",", $list);
		$order = 1;
		foreach ($items as $value) {
			if ($value != '') {
				
				$navigation_edit = new NavigationLink();
				$navigation_edit->where('id', $value)->update(array('position'=>$order));
				
				$order++;
			}
		}
	}
	function navigation_create($id=0)
	{
		$data['view'] = 'navigation/create_edit';

		$navigation_edit = "";
		$navigation_parent = "";
		
		$pagelist = new Page();
		$pagelist->select('title,id')->where(array('deleted_at' => NULL))->get();
				
		$navigationGroupList = new NavigationGroup();
		$navigationGroupList->select('title,id')->where(array('deleted_at' => NULL))->get();
				
		
		if($id>0)
		{
			$navigation_edit = new NavigationLink();
			$navigation_edit->select('id,title,parent,link_type,page_id,url,uri,navigation_group_id,target,restricted_to,class')
			->where('id',$id)->get();
			
			$navigation_parent = new NavigationLink();			
			$navigation_parent = $navigation_parent->where('id <>', $id)
			->where(array('deleted_at' => NULL))->select('title,id')->get();
				
		}
		else {
			$navigation_parent = new NavigationLink();			
			$navigation_parent = $navigation_parent->where(array('deleted_at' => NULL))
			->select('title,id')->get();
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
        	$navigation = new NavigationLink();
			if($id==0){
				$navigation->title = $this->input->post('title');
				$navigation->link_type = $this->input->post('link_type');	
				$navigation->parent = ($this->input->post('parent') != '') ? $this->input->post('parent') : NULL;	
				$navigation->page_id = $this->input->post('page_id');	
				$navigation->url = $this->input->post('url');	
				$navigation->uri = $this->input->post('uri');	
				$navigation->navigation_group_id = $this->input->post('navigation_group_id');	
				$navigation->target = $this->input->post('target');	
				$navigation->class = $this->input->post('class');
				$navigation->updated_at = date("Y-m-d H:i:s");										
				$navigation->created_at = date("Y-m-d H:i:s");
				$navigation->save();				
			}
			else {				
				$navigation->where('id', $id)->update(
						array('title'=>$this->input->post('title'), 
							'link_type'=>$this->input->post('link_type'), 
							'parent'=>($this->input->post('parent') != '') ? $this->input->post('parent') : NULL, 
							'page_id'=>$this->input->post('page_id'), 
							'url'=>$this->input->post('url'), 
							'uri'=>$this->input->post('uri'), 
							'navigation_group_id'=>$this->input->post('navigation_group_id'), 
							'target'=>$this->input->post('target'), 
							'class'=>$this->input->post('class'),							
							'updated_at'=>date("Y-m-d H:i:s")));
			}
        }
    }
	function navigation_delete($id)
	{
		$data['view'] = 'navigation/delete';
		$data['content'] = array('navigationlinkid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('navigationlinkid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('navigationlinkid');
			
			$navigationlink = new NavigationLink();
			$navigationlink->where('id', $id)
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	/*Pages*/
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $page = new Page();
        $page->where(array('deleted_at' => NULL))
			->select('id,title,status,voteup,votedown,hits,sidebar,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $page->paged->total_rows) {
            $offset = floor($page->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/pages/index/'),
            'first_url' => site_url('admin/pages/index/0'),
            'total_rows' => $page->paged->total_rows,
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
            'page' => $page,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$page_edit = $pluginfunction_content_all = $pluginfunction_slider_all = "";
						
		if($id<=0){
			$pluginfunction_content = new PluginFunction();	
			$plugins = new Plugin();
			
			$pluginfunction_content->where('type','content')
			->select('id,title, params, plugin_id')
			->get();
			
			foreach ($pluginfunction_content as $item) {
				$plugin = new Plugin();
				$plugin->select('name,function_id,function_grid')->where('id',$item->plugin_id)->get();
				$function_id = $plugin->function_id;
				$function_grid = $plugin->function_grid;
				if($function_id!=NULL){
					$item->function_id = modules::run($plugin->name.'/'.$function_id);
				}
				if($function_grid!=NULL){
					$item->function_grid = modules::run($plugin->name.'/'.$function_grid);
				}
			}	
					
			$pluginfunction_slider = new PluginFunction();
			$pluginfunction_slider->where('type','sidebar')
			->select('id,title, params')->get();
		}
		else
		{
			$page_edit = new Page();
			$page_edit->where('id',$id)->get();		
			/*select content plugins that added to page*/
			
			
			$pluginfunction_content = $this->db->from('page_plugin_functions ppf')
												->join('plugin_functions pf','pf.id = ppf.plugin_function_id' ,'left')
												->join('plugins p','p.id = pf.plugin_id' ,'left')
												->where('ppf.deleted_at', NULL)
												->where('page_id', $id)
												->where('pf.type','content')
												->order_by('ppf.order','ASC')
												->group_by('pf.id')
												->select('pf.id, ppf.plugin_function_id, p.name,pf.title, ppf.order, p.function_id, pf.function, pf.params, p.function_grid')
												->get()->result();
			$pluginfunction_content_all =  $this->db->from('plugin_functions pf')
													->join('plugins p', 'p.id = pf.plugin_id')
													->where('type','content')
													->where('pf.deleted_at', NULL)
													->select('pf.title, p.name, p.function_id, pf.id, pf.function, pf.params, p.function_grid')
													->get()->result();
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
					$temp1 =  $this->db->from('page_plugin_functions ppf')
													->where('param','id')
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$item->plugin_function_id)
													->select('value')					
													->get()->first_row();
					if(!empty($temp1))
					$item->ids = $temp1->value;
					$temp1 =  $this->db->from('page_plugin_functions ppf')
													->where('param','grid')
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$item->plugin_function_id)
													->select('value')
													->get()->first_row();
					if(!empty($temp1))
					$item->grids = $temp1->value;
					$temp1 =  $this->db->from('page_plugin_functions ppf')
													->where('param','sort')
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$item->plugin_function_id)
													->select('value')
													->get()->first_row();
					if(!empty($temp1))
					$item->sorts = $temp1->value;
					$temp1 =  $this->db->from('page_plugin_functions ppf')
													->where('param','limit')
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$item->plugin_function_id)
													->select('value')
													->get()->first_row();
					if(!empty($temp1))
					$item->limits = $temp1->value;
					$temp1 =  $this->db->from('page_plugin_functions ppf')
													->where('param','order')
													->where('page_id',$id)
													->where('ppf.deleted_at', NULL)
													->where('plugin_function_id',$item->plugin_function_id)
													->select('value')
													->get()->first_row();
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
			
			$pluginfunction_slider = $this->db->from('page_plugin_functions ppf')
												->join('plugin_functions pf','pf.id = ppf.plugin_function_id' ,'left')
												->where('page_id', $id)
												->where('pf.type','sidebar')
												->where('ppf.deleted_at', NULL)
												->order_by('ppf.order','ASC')
												->group_by('pf.id')
												->select('pf.id, pf.title, ppf.order')
												->get()->result();
													
			$pluginfunction_slider_all =  $this->db->from('plugin_functions pf')
													->where('type','sidebar')
													->where('pf.deleted_at', NULL)
													->select('pf.id, pf.title')
													->get()->result();
			
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
        	$page = new Page();
			if($id==0){
				$page->title = $this->input->post('title');	
				$page->slug = url_title( $this->input->post('title'), 'dash', true);
				$page->meta_title = $this->input->post('meta_title');
				$page->meta_description = $this->input->post('meta_description');
				$page->meta_keywords = $this->input->post('meta_keywords');
				$page->page_css = $this->input->post('page_css');
				$page->page_javascript = $this->input->post('page_javascript');
				$page->sidebar = $this->input->post('sidebar');
				$page->showtitle = $this->input->post('showtitle');
				$page->showvote = $this->input->post('showvote');
				$page->showdate = $this->input->post('showdate');
				$page->password = $this->input->post('password');
				$page->tags = $this->input->post('tags');
				$page->showtags = $this->input->post('showtags');
				$page->content = $this->input->post('content');
				$page->status = $this->input->post('status');
				$page->updated_at = date("Y-m-d H:i:s");										
				$page->created_at = date("Y-m-d H:i:s");
				$page->save();
				$id = $page->id;
			}
			else {				
				$page->where('id', $id)->update(array('title'=>$this->input->post('title'),
							'slug' =>url_title( $this->input->post('title'), 'dash', true),
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
							'updated_at'=>date("Y-m-d H:i:s")));
							
				$old = new PagePluginFunction();				
				$old->where('page_id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
			
			}
			$file='';
			if($_FILES['image']['name']!=""){
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
			
			}
			if($file!=""){
				$page->where('id', $id)->update(array('image'=>$file));
			}
			
			
			$pagesidebar = ($this->input->post('pagesidebar')!="")?$this->input->post('pagesidebar'):"";
			$pagecontentorder = $this->input->post('pagecontentorder');
			$pagecontent = $this->input->post('pagecontent');
		
			$this->SaveData($pagesidebar,$pagecontentorder, $pagecontent,$id);
        }

		
    }
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('pageid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('pageid', "Page", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('pageid');
			
			$page = new Page();
			$page->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function change($id)
	{
		$page = new Page();
		$page->where('id', $id)->get();
		$page->where('id', $id)->update(array('status'=>($page -> status + 1) % 2,
											'updated_at'=>date("Y-m-d H:i:s")));
		
		return redirect(base_url('admin/pages'));
		
	}
	function saveData($pagesidebar="",$pagecontentorder,$pagecontent,$page_id)
	{
		if($pagesidebar!=""){
				$order = 1;
				foreach ($pagesidebar as $value) {
					$plugin_function = new PluginFunction();
					$plugin_function->where('id', $value)->get();
					$params = $plugin_function->params;
					if($params!=NULL){
						$params = explode(';', $params);
						foreach ($params as $param) {
							if($param!=""){
								$param = explode(':', $param);
								$pagepluginfunction = new PagePluginFunction();
								$pagepluginfunction -> plugin_function_id = $value;
								$pagepluginfunction -> order = $order;
								$pagepluginfunction -> param = $param['0'];
								if(strstr($param['1'], ',')){
									$pagepluginfunction -> type = 'array';
								}
								else if(is_int($param['1'])){
									$pagepluginfunction -> type = 'int';
								}
								else {
									$pagepluginfunction -> type = 'string';
								}
								$pagepluginfunction -> value = $param['1'];
								$pagepluginfunction -> page_id = $page_id;
								$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
								$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
								$pagepluginfunction -> save();
							}
						}
					}	
				else {
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order;
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
						$pagepluginfunction -> save();
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
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'id';
						$pagepluginfunction -> type = 'array';
						$pagepluginfunction -> value = rtrim($params, ",");
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
						$pagepluginfunction -> save();
												
					}
					if(!empty($pagecontent[$value]['grid'])){
						foreach ($pagecontent[$value]['grid'] as $value2) {
							$params .= $value2.",";
						}
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'grid';
						$pagepluginfunction -> type = 'array';
						$pagepluginfunction -> value = rtrim($params, ",");
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");						
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['sort'])){
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'sort';
						$pagepluginfunction -> type = 'string';
						$pagepluginfunction -> value = $pagecontent[$value]['sort'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['order'])){
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'order';
						$pagepluginfunction -> type = 'string';
						$pagepluginfunction -> value = $pagecontent[$value]['order'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
						$pagepluginfunction -> save();
					}
					if(isset($pagecontent[$value]['limit'])){
						$pagepluginfunction = new PagePluginFunction();
						$pagepluginfunction -> plugin_function_id = $value;
						$pagepluginfunction -> order = $order2;
						$pagepluginfunction -> param = 'limit';
						$pagepluginfunction -> type = 'int';
						$pagepluginfunction -> value = $pagecontent[$value]['limit'];
						$pagepluginfunction -> page_id = $page_id;
						$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
						$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
						$pagepluginfunction -> save();
					}
					if(empty($pagecontent[$value]['id']) && empty($pagecontent[$value]['grid']) && 
						!isset($pagecontent[$value]['sort']) && !isset($pagecontent[$value]['order']) &&
						!isset($pagecontent[$value]['limit']))
						{
							$pagepluginfunction = new PagePluginFunction();
							$pagepluginfunction -> plugin_function_id = $value;
							$pagepluginfunction -> order = $order2;
							$pagepluginfunction -> param = '';
							$pagepluginfunction -> type = '';
							$pagepluginfunction -> value = '';
							$pagepluginfunction -> page_id = $page_id;
							$pagepluginfunction -> updated_at = date("Y-m-d H:i:s");										
							$pagepluginfunction -> created_at = date("Y-m-d H:i:s");
							$pagepluginfunction -> save();
						}
					
					$order2 ++;
				}
	}
}