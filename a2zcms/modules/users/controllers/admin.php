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
		$validation_password = 'required';
		$validation_email = "|valid_email|is_unique[users.email]";
		$validation_username = "|is_unique[users.username]";
		if($id>0)
		{
			$validation_password='';
			$validation_email ='';
			$validation_username = '';
			
			$user = new User();
			$user_edit = $user->select('id,name,surname,email,username,confirmed,active,created_at') 
							->where('id',$id)
							->where(array('deleted_at' => NULL))
							->get();
							
			$assignedrole = new AssignedRole();
			$assignedrole->select('role_id') 
							->where('user_id',$id)
							->where(array('deleted_at' => NULL))
							->get();
		}
		
		$roles = new Role();
		$roles->select('id,name')->where(array('deleted_at' => NULL))->get();
							
		$data['content'] = array('user_edit' => $user_edit, 
								'assignedrole' =>$assignedrole,
								'roles' => $roles,
								'user_id' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('name', "Name", 'required');
		$this->form_validation->set_rules('surname', "Surname", 'required');
		$this->form_validation->set_rules('email', "Email", 'required'.$validation_email);
	   	$this->form_validation->set_rules('username', "Username", 'required'.$validation_username);
	   	$this->form_validation->set_rules('password', "Password", $validation_password);
	   	
	   	if ($this->form_validation->run() == TRUE)
        {
        	$this->load->library('hash');
			
        	$user = new User();
			if($id==0){
				$user->name = $this->input->post('name');
				$user->surname = $this->input->post('surname');
				$user->email = $this->input->post('email');
				$user->username = $this->input->post('username');
				$user->password = $this->hash->make($this->input->post('password'));
				$user->confirm_password= $this->hash->make($this->input->post('password'));									
				$user->confirmation_code = rand(9999, 99999999);
				$user->confirmed =  1;
				$user->active = $this->input->post('active');			
				$user->updated_at = date("Y-m-d H:i:s");										
				$user->created_at = date("Y-m-d H:i:s");
				$user->save();
				$id = $user->id;
			}
			else {				
				$user->where('id',$id)
						->update(array(
									'name'=>$this->input->post('name'), 
									'surname'=>$this->input->post('surname'), 
									'active'=>$this->input->post('active'),
									'updated_at'=>date("Y-m-d H:i:s")));
				
				$user = new User();					
				if($this->input->post('password')!="")
				{
					$user->where('id', $id)->update(array(
									'password'=>$this->hash->make($this->input->post('password'))));
				}
				
				$ar = new AssignedRole();
				$ar->where('user_id', $id)->update('deleted_at', date("Y-m-d H:i:s"));
			}
			$roles = $this->input->post('roles');
			if(!empty($roles)){
				foreach($roles as $key => $role_id)
		        {
		        	$ar = new AssignedRole();
		        	$ar->role_id = $role_id;
					$ar->user_id = $id;
					$ar->created_at = date("Y-m-d H:i:s");
					$ar->updated_at = date("Y-m-d H:i:s");
					$ar->save();			
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