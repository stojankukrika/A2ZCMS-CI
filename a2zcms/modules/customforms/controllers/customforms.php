<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Customforms extends Website_Controller{
	
	private $page;
	private $pagecontent;
	function __construct()
    {
        parent::__construct();
		$this->load->model(array("Model_customform","Model_customform_field","Model_content_vote"));
		$this->pagecontent = Website_Controller::createSiderContent(0);
    }
	/*function for plugins*/	
	function getCustomFormId(){
		$customform = $this->Model_customform->getall();
	return array('customform' =>$customform);
	}
	/*function for website part*/
	function showCustomFormId($ids,$grids,$sorts,$limits,$orders)
	{
		$showCustomFormId ="";
		$showCustomFormFildId ="";
		$ids = rtrim($ids, ",");

		if($ids!=""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			$showCustomFormId = $this->Model_customform->selectWhereIn($ids);
			foreach ($ids as $id){
				$showCustomFormFildId[$id] = $this->Model_customform_field->selectForId($id);
			}
		}
		$data['showCustomFormId'] = $showCustomFormId;
		$data['showCustomFormFildId'] = $showCustomFormFildId;
		$this->load->view('customforms',$data);
	}
	
	function item($id)
	{
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		$customform = $this->Model_customform->select($id);
		$data['showCustomFormId'] = $customform;	
		
		$showCustomFormFildId = $this->Model_customform_field->selectorder('order',$id);		
		$data['showCustomFormFildId'] = $showCustomFormFildId;
		
		$this->load->view('customform',$data);		
		
		$contactemail = $this->session->userdata("contactemail");
		
		$emailadmin = $contactemail.';'.$customform->recievers;
		$rules = array();
		foreach ($data['showCustomFormFildId'] as $fields) {
			switch ($fields->mandatory) {
				case '2':
					$this->form_validation->set_rules(url_title($fields->name, 'dash', true), $fields->name, 'required');
					break;
				case '3':
					$this->form_validation->set_rules(url_title($fields->name, 'dash', true), $fields->name, 'required|numeric');
					break;
				case '4':
					$this->form_validation->set_rules(url_title($fields->name, 'dash', true), $fields->name, 'required|email');
					break;
			}			
		}
		// Check if the form validates with success
		if ($this->form_validation->run() == TRUE)
		{
			
			// Save the comment
			$this->load->library('email');
			$data = $this->input->post();
			
			$emailadmin = explode(';', $emailadmin);
			foreach ($emailadmin as $email) {
				if($email!=""){	
					$this->email->to($email);
					$this->email->from($contactemail);							
					$this->email->subject('Contact message');
					$mail_text = "";
					foreach($data  as $key => $val)
					{
						$mail_text .= "<p>".$key. " :" . $val . "</p>\n";
					}
					$this->email->message($mail_text);
					
					$this->email->send();
				}
			}
		}
	}
		
}
?>