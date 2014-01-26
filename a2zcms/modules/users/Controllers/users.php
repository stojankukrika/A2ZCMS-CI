<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Users extends Website_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model('user');		
		$this->load->library('form_validation');
	
	}
	
	function index(){
		$users = new User();		
		$data["users"] = $users->get();
		$data['main_content'] = 'users';
		$this->load->view('page', $data);
	}
	
	function user($username){
		$users = new User();	
		$data["user"] =$users->where('username', $username)->get();
		
		if($data["user"]){
			$data['main_content'] = 'user';
			$this->load->view('page', $data);
		}else{
			show_404();
		}
		
	}
	
	function login(){
		//Redirect
		if($this->_is_logged_in()){
			redirect('');
		}
		
		if($_POST){
			
			// Create user object
	        $u = new User();
	
	        // Put user supplied data into user object
	        // (no need to validate the post variables in the controller,
	        // if you've set your DataMapper models up with validation rules)
	        $u->username = $this->input->post('username');
	        $u->password = $this->input->post('password');
		
			  if ($u->login())
		        {
		        	$data = array(
					'username' => $u->username,
					'name' => $u->name,
					'surname' => $u->surname,
					'is_logged_in' => true
					);
					$this->session->set_userdata($data);
					redirect('');
		        }
		        else
		        {
		            // Show the custom login error message
		            echo '<p>' . $u->error->login . '</p>';
		        }
		}
		$data['main_content'] = 'index';
		$this->load->view('page');
	}
	
	function signup(){
		if($_POST){
		// Create user object
	        $u = new User();
	
	        // Put user supplied data into user object
	        // (no need to validate the post variables in the controller,
	        // if you've set your DataMapper models up with validation rules)
	        $u->username = $this->input->post('username');
	        $u->password = $this->input->post('password');
	        $u->confirm_password = $this->input->post('confirm_password');
	        $u->email = $this->input->post('email');

	        // Attempt to save the user into the database
	        if ($u->save())
	        {
	            echo '<p>You have successfully registered</p>';
	        }
	        else
	        {
	            // Show all error messages
	            echo '<p>' . $u->error->string . '</p>';
	        }
		}
		$data['main_content'] = 'signup';
		$this->load->view('page', $data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
	
	function account(){
		//Redirect
		$this->_member_area();
		
		if($_POST){
			$userdata = new stdClass();
			$userdata->user_nicename 	= $this->input->post('nickname');
			$userdata->user_email 		= $this->input->post('email');
			$userdata->user_pass		= md5($this->input->post('password'));
			
			$insert = $this->user_model->update($this->session->userdata('userid'), $userdata);
			
			if($insert){
				$data['message'] = "Updated succesfully";
				$data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
				$data['main_content'] = 'account';
				$this->load->view('page', $data);
			}
			return;
		}
		
		$data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
		$data['main_content'] = 'account';
		$this->load->view('page', $data);
		
	}
	
//Hidden Methods not allowed by url request

	function _member_area(){
		if(!$this->_is_logged_in()){
			redirect('signin');
		}
	}
	
	function _is_logged_in(){
		if($this->session->userdata('logged_in')){
			return true;
		}else{
			return false;
		}
	}
	
	function userdata(){
		if($this->_is_logged_in()){
			return $this->user_model->user_by_id($this->session->userdata('userid'));
		}else{
			return false;
		}
	}
	
	function _is_admin(){
		if(@$this->users->userdata()->role === 1){
			return true;
		}else{
			return false;
		}
	}
		
}

?>