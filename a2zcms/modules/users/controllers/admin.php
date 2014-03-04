<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Admin extends Administrator_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array("Model_user", "Model_assigned_role","Model_role","Model_user_login_history"));
		if (!$this->session->userdata("manage_users")){
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
		$users = $this->Model_user->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
        
        $pagination_config = array(
            'base_url' => site_url('admin/users/index/'),
            'first_url' => site_url('admin/users/index/0'),
            'total_rows' => $this->Model_user->total_rows(),
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
            'users' => $users
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
		
		$users = $this->Model_user->fetch_paging_role($this->session->userdata('pageitemadmin'),$offset,$role_id);
 		$role = $this->Model_role->select($role_id);
		
        $pagination_config = array(
            'base_url' => site_url('admin/users/listusersforrole/'.$role_id.'/'),
            'first_url' => site_url('admin/users/listusersforrole/'.$role_id.'/0'),
            'total_rows' => $this->Model_user->total_rows_role($role_id),
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
            'role' => $role,
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
			
			$user_edit = $this->Model_user->select($id);
							
			$assignedrole = $this->Model_assigned_role->selectuser($id);
		}
		
		$roles = $this->Model_role->getall($id);
							
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
        	$passwordOk = "";
        	if($this->session->userdata('passwordpolicy')=="Yes"){	        		
	        	$varname = array('minpasswordlength','minpassworddigits','minpasswordlower',
	        					'minpasswordupper','minpasswordnonalphanum');
				$this->db->where_in('varname',$varname);
				$query = $this->db->from('settings')->get();
				foreach ($query->result() as $row)
				{
					switch ($row->varname) {
						case 'minpasswordlength':
								if(!strlen($this->input->post('password'))>=$row->value) 
								$passwordOk = "Password do not corresponding to Password policy.";
							break;
						case 'minpassworddigits':
								if(!preg_match('/[0-9]{'.$row->value.'}+/', $this->input->post('password'))) 
								$passwordOk = "Password do not corresponding to Password policy.";
							break;
						case 'minpasswordlower':
								if(!preg_match('/[a-z]{'.$row->value.'}+/', $this->input->post('password'))) 
								$passwordOk = "Password do not corresponding to Password policy.";
							break;
						case 'minpasswordupper':
								if(!preg_match('/[A-Z]+/', $this->input->post('password'))) 
								$passwordOk = "Password do not corresponding to Password policy.";
							break;
					}
				}
        	}			
        	if($passwordOk==""){
        		$this->load->library('hash');
				if($id==0){
					$this->Model_user->insert(array('name'=>$this->input->post('name'),
												'surname'=>$this->input->post('surname'),
												'email'=>$this->input->post('email'),
												'username'=>$this->input->post('username'),
												'password'=>$this->hash->make($this->input->post('password')),
												'confirmation_code'=>rand(9999, 99999999),
												'confirmed'=>1,
												'active'=>$this->input->post('active'),												
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
				}
				else {
					$this->Model_user->update(array('name'=>$this->input->post('name'), 
													'surname'=>$this->input->post('surname'), 
													'active'=>$this->input->post('active'),
													'updated_at'=>date("Y-m-d H:i:s")),$id);
					if($this->input->post('password')!="")
					{
						$this->Model_user->update(array('password'=> $this->hash->make($this->input->post('password')), 
													'updated_at'=>date("Y-m-d H:i:s")),$id);
					}
					$this->Model_assigned_role->deleteuser($id);
					
				}	
			
			$roles = $this->input->post('roles');
			if(!empty($roles)){
				foreach($roles as $key => $role_id)
		        {
		        	$this->Model_assigned_role->insert(array('role_id'=>$role_id,
												'user_id'=>$id,												
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
		        }
			}
		 }
       }
    }
	function listlogins($id)
	{
		$data['view'] = 'listlogins';
		
		$offset = (int)$this->uri->segment(5);
        if (!($offset > 0)) {
            $offset = 0;
        }
		
        $userlogins = $this->Model_user_login_history->fetch_paging_user($this->session->userdata('pageitemadmin'),$offset,$id);

        $user =  $this->Model_user->select($id);
								
        $pagination_config = array(
            'base_url' => site_url('admin/users/listlogins/'.$id.'/'),
            'first_url' => site_url('admin/users/listlogins/'.$id.'/0'),
            'total_rows' => $this->Model_user_login_history->total_rows_user($id),
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
            'user' => $user
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
        	$this->Model_user->delete($id);
        }
	}
		
}

?>