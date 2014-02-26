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
		$this->load->model(array("Model_customform","Model_customform_field"));
		$this->page = $this->db->limit(1)->get('pages')->first_row();
		$this->pagecontent = Website_Controller::createSiderContent($this->page->id);
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
			$showCustomFormId = $this->db->where_in('id', $ids)
										->select('id, recievers, title, message')
										->get('custom_forms')->result();
			foreach ($ids as $id){
				$showCustomFormFildId[$id] = $this->db->where_in('custom_form_id', $id)
										->select('id, name, options, type, order, mandatory')
										->order_by('order','ASC')
										->get('custom_form_fields')->result();
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
		$customform = $this->db->where('id',$id)->get('custom_forms')->first_row();
		$data['showCustomFormId']= $customform;	
		$customform_fields = $this->db->where('custom_form_id', $id)
										->select('id, name, options, type, order, mandatory')
										->order_by('order','ASC')
										->get('custom_form_fields');	
		$data['showCustomFormFildId']= $customform_fields->result();		
				
		$emailadmin = $this->session->userdata("email");
		
		$emailadmin = $emailadmin.','.$customform->recievers;
		$rules = array();
		foreach ($customform_fields->result_array() as $fields) {
			switch ($fields['mandatory']) {
				case '2':
					$rules[$fields->name] = 'required|';
					break;
				case '3':
					$rules[$fields->name] = 'required|numeric';
					break;
				case '4':
					$rules[$fields->name] = 'required|email';
					break;
			}			
		}
		$this->form_validation->set_rules($rules); 
		
		// Check if the form validates with success
		if ($this->form_validation->run() == FALSE)
		{
			// Save the comment
			$this->load->library('email');
			$data = $this->input->post();
			
			if (strpos($emailadmin,'.') !== false && strpos($emailadmin,'@') !== false && strlen($emailadmin)>6) {
			
			$emailadmin = explode(';', $emailadmin);
			foreach ($emailadmin as $email) {
				if($email!=""){	
					$this->email->to($emailadmin);
					$this->email->from($emailadmin);							
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
			
		$this->load->view('customform',$data);
	}
		
}
?>