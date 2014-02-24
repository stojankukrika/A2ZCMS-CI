<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Users extends Website_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model(array('Model_user', "Model_message"));		
	
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
					'admin_logged_in' => $this->_is_admin($user->id),
					);
					$this->session->set_userdata($data);
					redirect('');
		        }
		        else
		        {
		        	echo '<br><p class="text-danger">Wrong username or password!</p>';
		        }
		}
		$data['main_content'] = 'index';
		$this->load->view('login');
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
				$code = md5(microtime() . $this->input->post('password'));
				$this->Model_user->insert(array('name'=>$this->input->post('name'),
											'surname'=>$this->input->post('surname'),
											'username'=>$this->input->post('username'),
											'password'=>$this->hash->make($this->input->post('password')),
											'email'=>$this->input->post('email'),
											'confirmation_code'=> $code,
											'confirmed'=>0,
											'active'=>1,
											'created_at' => date("Y-m-d H:i:s"),
											'updated_at' => date("Y-m-d H:i:s")));
	        	echo '<div class="container"><div class="col-xs-12 col-sm-6 col-lg-8"><br>
						<div class="row">You have successfully registered</p></div></div></div>';
					
					//Send validation mail 
					
					$this->load->library('email');

					$this->email->from($this->Model_user->getsiteemail()->value, $this->Model_user->getsitetitle()->value);
					$this->email->to($this->input->post('email')); 
					
					$this->email->subject('Confirmation');
					$this->email->message("Confirm your subscription <a href=''>Confirmar</a>".$code);	
					$this->email->send();
	        }
	        else
	        {
	            echo '<br><p class="text-danger">Password not equal</p>';
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
	
	function _is_admin($user_id=0)
	{
		$roles = $this->Model_user->isadmin($user_id);
		$is_admin = false;
		if(!empty($roles)){
			foreach($roles as $item)
			{
				if($item->is_admin=='1')
				{
					$is_admin = true;
				}
			}	
		}	 
		return $is_admin;
	}

	function account ()
	{
		
		$data['main_content'] = 'changepassword';		
		$this->load->view('page', $data);
		$this->load->library('hash');					
		if($this->input->post('old_password')!="" && $this->input->post('password')!="" && $this->input->post('password')==$this->input->post('confirm_password'))
		{
			$user = $this->Model_user->selectuser($this->session->userdata('username'));
			if($user->password==$this->hash->make($this->input->post('old_password')))
			{
				$data = array('password'=>$this->hash->make($this->input->post('password')));
				$this->Model_user->update($data,$this->session->userdata('user_id'));
				$this->logout();
			}
			else {
				echo '<br><p class="text-danger">Old password is not valid!</p>';
			}
		}
	}
	
	function messages ()
	{
		$data['send'] = $this->Model_message->selectSend($this->session->userdata('user_id'));
		$data['received'] = $this->Model_message->selectReceived($this->session->userdata('user_id'));
		$data['allUsers'] = $this->Model_user->selectAll($this->session->userdata('user_id'));
		$data['main_content'] = 'messages';
		$this->load->view('page', $data);
	}
	
	function readmessage($id_message)
	{
		$data = array('read'=>1, 'updated_at'=>date("Y-m-d H:i:s"));
		$this->Model_message->update($data,$id_message);
	}
	
	function sendmessage()
	{
		if($this->input->post('subject')!="" && $this->input->post('recipients')!="")
		{
			foreach($this->input->post('recipients') as $to){
				$this->Model_message->insert(array('subject'=>$this->input->post('subject'),
											'user_id_from'=>$this->session->userdata('user_id'),
											'user_id_to'=>$to,
											'content'=>$this->input->post('message'),
											'read'=>'0',
											'created_at' => date("Y-m-d H:i:s"),
											'updated_at' => date("Y-m-d H:i:s")));
			}
		}
		redirect(base_url('users/messages'));
	}
	function deletereceiver($id_message)
	{
		$this->Model_message->deletereceiver($id_message);
	}
	function deletesender($id_message)
	{
		$this->Model_message->deletesender($id_message);
	}
	
	function forgot()
	{
		$data['main_content'] = 'forgot';
		$this->load->view('page', $data);
		if($_POST){
			  if ($u = $this->Model_user->checkuser($this->input->post('username'),$this->input->post('email')))
		        {
		        	$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				    $randstring = '';
				    for ($i = 0; $i < 8; $i++) {
				        $randstring = $characters[rand(0, strlen($characters))];
				    }
					$this->load->library('hash');	
					$data = array('password'=>$this->hash->make($randstring));
					$this->Model_user->update($data,$u->id);
				
					//Send validation mail 
					
					$this->load->library('email');

					$this->email->from($this->Model_user->getsiteemail()->value, $this->Model_user->getsitetitle()->value);
					$this->email->to($this->input->post('email')); 
					
					$this->email->subject('Change password');
					$this->email->message("Your password is changed to: ".$randstring);	
					$this->email->send();
					
				}
			  else {
			  	echo '<br><p class="text-danger">Username and email is not match in users of this site!</p>';
			  }
		}
	
	}	
	
}

?>