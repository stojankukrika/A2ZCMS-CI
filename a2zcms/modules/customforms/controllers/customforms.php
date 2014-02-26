<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Customforms extends Website_Controller{

	function __construct()
    {
        parent::__construct();
		$this->load->model(array("Model_customform","Model_customform_field"));
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
		
}
?>