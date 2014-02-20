<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Users extends Website_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model('Model_user');		
	
	}
	function login(){
			
		if($this->_is_logged_in()){
			redirect('');
		}
		
		if($_POST){
			  if ($u = $this->Model_user->login($this->input->post('username'),$this->input->post('password')))
		        {		        													
		        	$user = $this->Model_user->selectuser($this->input->post('username'));
		        	$data = array(
		        	'user_id' => $user->id,
					'username' => $user->username,
					'name' => $user->name,
					'surname' => $user->surname,
					'logged_in' => true,
					'admin_logged_in' => true,
					);
					$this->session->set_userdata($data);
					redirect('');
		        }
		        else
		        {
		            echo '<p>Wrong username or password!</p>';
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
			
			if($this->input->post('password')!="" && $this->input->post('password')==$this->input->post('confirm_password'))
			{
				$this->Model_user->insert(array('name'=>$this->input->post('name'),
											'surname'=>$this->input->post('surname'),
											'username'=>$this->input->post('username'),
											'password'=>$this->hash->make($this->input->post('password')),
											'email'=>$this->input->post('email'),
											'confirmation_code'=> md5(microtime() . $this->input->post('password')),
											'confirmed'=>0,
											'active'=>1,
											'updated_at' => date("Y-m-d H:i:s")));
	        	echo '<div class="container"><div class="col-xs-12 col-sm-6 col-lg-8"><br>
						<div class="row">You have successfully registered</p></div></div></div>';
	        }
	        else
	        {
	            echo '<div class="container">
	            	<div class="col-xs-12 col-sm-6 col-lg-8"><br>
					<div class="row">Password not equal</p></div></div></div>';
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
			return $this->Model_user->select($this->session->userdata('user_id'));
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