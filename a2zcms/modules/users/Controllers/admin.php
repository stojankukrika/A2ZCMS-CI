<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model("user");					
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $users = new User();
		
        $users->where(array('deleted_at' => NULL))
			->select('id,name,surname,email,username,confirmed,active,last_login,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $users->paged->total_rows) {
            $offset = floor($users->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/users/index/'),
            'first_url' => site_url('admin/users/index/0'),
            'total_rows' => $users->paged->total_rows,
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
            'users' => $users,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function listusersforrole($role_id)
	{
		$data['view'] = 'listusersforrole';
		
		$offset = (int)$this->uri->segment(5);
        if (!($offset > 0)) {
            $offset = 0;
        }
		
		$assignedrole = new AssignedRole();
		$assignedrole->select('user_id')->where(array('deleted_at' => NULL))->where('role_id',$role_id)->get();
		$userroles = array();
		
		foreach ($assignedrole as $item) {
			$userroles[]=$item->user_id;
		}
		
        $users = new User();		
        $users->where(array('deleted_at' => NULL))->where_in('id',$userroles)
			->select('id,name,surname,email,username,confirmed,active,last_login,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $users->paged->total_rows) {
            $offset = floor($users->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/users/listusersforrole/'.$role_id.'/'),
            'first_url' => site_url('admin/users/listusersforrole/'.$role_id.'/0'),
            'total_rows' => $users->paged->total_rows,
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 5,
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
            'users' => $users,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$user_edit = array();
		$assignedrole = array();
		
		if($id>0)
		{
			$user = new User();
			$user_edit = $user->select('id,name,surname,email,username,confirmed,active,created_at') 
							->where('id',$id)
							->where(array('deleted_at' => NULL))
							->get();
							
			$assignedrole = new AssignedRole();
			$assignedrole->select('id') 
							->where('user_id',$id)
							->where(array('deleted_at' => NULL))
							->get();
		}
		
		$data['content'] = array('user_edit' => $user_edit, 
								'assignedrole' =>$assignedrole,
								'user_id' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('name', "Name", 'required');
		$this->form_validation->set_rules('surname', "Surname", 'required');
		$this->form_validation->set_rules('email', "Email", 'required|valid_email|is_unique[users.email]');
	   	$this->form_validation->set_rules('username', "Username", 'required|is_unique[users.username]');
	   	
	   	
	   	if ($this->form_validation->run() == TRUE)
        {
        	$name = $this->input->post('name');
			$permissions = $this->input->post('permission');
			
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
							'updated_at'=>date("Y-m-d H:i:s"), 'created_at'=>date("Y-m-d H:i:s")));
				
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
	function listlogins($id)
	{
		$data['view'] = 'listusersforrole';
		
		$offset = (int)$this->uri->segment(5);
        if (!($offset > 0)) {
            $offset = 0;
        }
		
        $userlogins = new UserLoginHistorys();		
        $userlogins->where(array('deleted_at' => NULL))->where('user_id',$id)
			->select('created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $userlogins->paged->total_rows) {
            $offset = floor($userlogins->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 		$user = new User();
		$user ->select('id,name,surname') 
								->where('id',$id)
								->where(array('deleted_at' => NULL))
								->get();
								
        $pagination_config = array(
            'base_url' => site_url('admin/users/listlogins/'.$id.'/'),
            'first_url' => site_url('admin/users/listlogins/'.$id.'/0'),
            'total_rows' => $userlogins->paged->total_rows,
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 5,
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
            'userlogins' => $userlogins,
            'user' => $user,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('userid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('userid', "userid", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('userid');
			
			$user = new User();
			$user->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
		
}

?>