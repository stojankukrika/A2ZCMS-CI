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

}