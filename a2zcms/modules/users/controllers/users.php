<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Users extends Website_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model('user');		
	
	}
	function login(){
			
		if($this->_is_logged_in()){
			redirect('');
		}
		
		if($_POST){
			
	        $u = new User();
	        $u->username = $this->input->post('username');
	        $u->password = $this->input->post('password');
					
			  if ($u->login())
		        {
		        	$data = array(
		        	'user_id' => $u->id,
					'username' => $u->username,
					'name' => $u->name,
					'surname' => $u->surname,
					'logged_in' => true,
					'admin_logged_in' => true,
					);
					$this->session->set_userdata($data);
					redirect('');
		        }
		        else
		        {
		            echo '<p>' . $u->error->login . '</p>';
		        }
		}
		$data['main_content'] = 'index';
		$this->load->view('page');
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
	
	function register(){
		
		$this->_member_area();
		if($_POST){
			$this->load->library('hash');
			
			$u = new User();
			$u->name = $this->input->post('name');
	        $u->surname = $this->input->post('surname');
			$u->username = $this->input->post('username');
	        $u->password = $this->hash->make($this->input->post('password'));
	        $u->confirm_password = $this->hash->make($this->input->post('confirm_password'));
	        $u->email = $this->input->post('email');
			$u->confirmation_code = rand(9999, 99999999);
			$u->confirmed = 0;
			$u->active = 1;
			  if ($u->save())
		        {
		            echo 'div class="col-xs-12 col-sm-6 col-lg-8"><br>
						<div class="row">You have successfully registered</p></div></div>';
		        }
		        else
		        {
		            echo 'div class="col-xs-12 col-sm-6 col-lg-8"><br>
						<div class="row">' . $u->error->string . '</p></div></div>';
		        }
		}		
		$data['main_content'] = 'register';
		$this->load->view('page', $data);
		
	}
	
	function _member_area(){
		if($this->_is_logged_in()){
			redirect('');
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
			$user = new User();
			$user->select('id, name, surname, username,email');
			$user->where('username', $this->session->userdata('username'));
			$user->get(1);
			return $user;
		}else{
			return false;
		}
	}
	
	function _is_admin()
	{
		 if($this->session->userdata('logged_in')){
	                return true;
	        }else{
	                return false;
	        }
	}
}

?>