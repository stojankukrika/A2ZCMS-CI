<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();	
		$this->load->model(array("Model_permission","Model_permission_role","Model_role"));
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
		$role = $this->Model_role->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
		
        $pagination_config = array(
            'base_url' => site_url('admin/roles/index/'),
            'first_url' => site_url('admin/roles/index/0'),
            'total_rows' => $this->Model_role->total_rows(),
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
            'role' => $role
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$permissionsAdmin = $this->Model_permission->getallisadmin(1);
		$permissionsUser = $this->Model_permission->getallisadmin(0);
					
		$permisionsadd = "";
		$rolename = "";
		
		if($id>0)
		{
			$role = $this->Model_role->select($id);
			$rolename = $role->name;
			
			$permisions = $this->Model_permission_role->selectrole($id);
			$permisionsadd = $permisions;			
		}
		
		$data['content'] = array('permissionsUser' => $permissionsUser, 
								'permissionsAdmin' => $permissionsAdmin,
								'permisionsadd' => $permisionsadd,
								'rolename' => $rolename);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('name', "Name", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$is_admin = 0;
			
			$permissionsAdmin  = $this->Model_permission->getallisadmin(1);
								
			foreach ($permissionsAdmin as $perm){
					if(!empty($this->input->post('permission'))){
			            foreach($this->input->post('permission') as $item){
		            		if($item==$perm->id && $perm->is_admin =='1')
							{
								$is_admin = 1;
							}
			            }
					}
				}
			
			if($id==0){
				
				$id = $this->Model_role->insert(array('name'=>$this->input->post('name'),
														'is_admin'=>$is_admin,
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_role->update(array('name'=>$this->input->post('name'),
														'is_admin'=>$is_admin,
														'updated_at' => date("Y-m-d H:i:s")),$id);
				
				$this->Model_permission_role->delete($id);
			}
			if(!empty($this->input->post('permission'))){
				foreach($this->input->post('permission') as $key => $permission_id)
		        {
		        	$this->Model_permission_role->insert(array('permission_id'=>$permission_id,
												'role_id'=> $id,
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));				
		        }
			}
        }
    }
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('roleid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('roleid', "roleid", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('roleid');
			
			$this->Model_role->delete($id);
        }
	}
}

?>