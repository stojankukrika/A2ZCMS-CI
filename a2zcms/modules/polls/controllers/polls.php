<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Polls extends Website_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->language('polls', $this->session->userdata('lang'));
		$this->load->model(array("Model_poll"));
	}

	public function activePoll($params)
	{
		$poll = $polloptions="";
		$uservoted=false;
		$param = Website_Controller::splitParams($params);		
		$poll = $this->Model_poll->getAllByParams($param['order'],$param['sort'],$param['limit']);
		if(!empty($poll)){
			$polloptions = $this->Model_poll->selectOptions($poll->id);	
			$uservoted = $this->Model_poll->chechUserVoted($poll->id,$this->input->ip_address());	
		}
		$data['poll'] = $poll;
		$data['poll_options'] = $polloptions;
		$data['uservoted'] = $uservoted;
		
		$this->load->view('poll_partial',$data);
	}
    
	public function vote()
	{
		$this->form_validation->set_rules('pollvote', "Vote", 'required');
		if ($this->form_validation->run() == TRUE)
        {
        	$pollvote = $this->input->post('pollvote');
			$ip_address = $this->input->ip_address();
			$pollid = $this->input->post('pollid');
			if($this->Model_poll->chechUserVoted($pollid,$ip_address))
			{
				$option = $this->Model_poll->selectOptionForPoll($pollid,$pollvote);
				if($option->id>0){
					$this->Model_poll->insertVote(array('option_id'=>$pollvote,
												'ip_address'=>$ip_address,									
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
					$this->Model_poll->updateOption(array('votes'=>$option->votes+1),$option->id);
				}
				
			}
		}
		redirect('');
	}
}