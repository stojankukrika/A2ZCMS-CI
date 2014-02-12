<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();	
		$this->load->model("role");
		$this->load->model("permission");					
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $role = new Role();
		
        $role->where(array('deleted_at' => NULL))
			->select('id,name,is_admin,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
 		
 		foreach ($role as $item) {
 			$assignedrole = new AssignedRole();		
			$assignedrole->where('role_id', $item->id);
			$item->countusers = $assignedrole->count();
		 }
        if ($offset > $role->paged->total_rows) {
            $offset = floor($role->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/roles/index/'),
            'first_url' => site_url('admin/roles/index/0'),
            'total_rows' => $role->paged->total_rows,
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
            'role' => $role,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$permission = new Permission();
		$permissionsAdmin = $permission
								->select('id,name,display_name,is_admin') 
								->where('is_admin','1')
								->where(array('deleted_at' => NULL))
								->get();
								
		$permission = new Permission();
		$permissionsUser = $permission
								->select('id,name,display_name,is_admin') 
								->where('is_admin','0')
								->where(array('deleted_at' => NULL))
								->get();
					
		$permisionsadd = "";
		$rolename = "";
		
		if($id>0)
		{
			$role = new Role();
			$role->select('name')->where('id',$id)->get();
			$rolename = $role->name;
			
			$permisions = new PermissionRole();
			$permisions->select('permission_id')->where('role_id',$id)->where(array('deleted_at' => NULL))->get();
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
        	$name = $this->input->post('name');
			$permissions = $this->input->post('permission');
			$is_admin = 0;
			
			$permission = new Permission();
			$permissionsAdmin = $permission
								->select('id,name,display_name,is_admin') 
								->where('is_admin','1')
								->where(array('deleted_at' => NULL))
								->get();
								
			foreach ($permissionsAdmin as $perm){
					if(!empty($permissions)){
			            foreach($permissions as $item){
		            		if($item==$perm->id && $perm->is_admin ==1)
							{
								$is_admin = 1;
							}
			            }
					}
				}
			
			$role = new Role();
			if($id==0){
				$role->name = $name;
				$role->is_admin = $is_admin;	
				$role->updated_at = date("Y-m-d H:i:s");										
				$role->created_at = date("Y-m-d H:i:s");
				$role->save();
				$id = $role->id;
			}
			else {
				
				$role->where('id', $id)->update(array('name'=>$name, 'is_admin'=>$is_admin, 
							'updated_at'=>date("Y-m-d H:i:s")));
				
				$p = new PermissionRole();
				$p->where('role_id', $id)->update('deleted_at', date("Y-m-d H:i:s"));
			}
			if(!empty($permissions)){
				foreach($permissions as $key => $permission_id)
		        {
		        	$permissionrole = new PermissionRole();
		        	$permissionrole->permission_id = $permission_id;
					$permissionrole->role_id = $id;
					$permissionrole->created_at = date("Y-m-d H:i:s");
					$permissionrole->updated_at = date("Y-m-d H:i:s");
					$permissionrole->save();				
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
			
			$role = new Role();
			$role->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
}

?>