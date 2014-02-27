<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Pages extends Website_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(array("Model_page"));
	}
	
	public function index(){
		$page_id = ($this->uri->segment(3)!="")?$this->uri->segment(3):0;
		$pagecontent = Website_Controller::createSiderContent($page_id);
		// Show the page
		 $data['content'] = array(
            'right_content' => $pagecontent['sidebar_right'],
            'left_content' => $pagecontent['sidebar_left'],
            'main_content' => $pagecontent['content']
        );
		$this->load->view("page", $data);
	}
	
	public function getsitetitle()
	{
		return $this->db->where('varname', 'title')
						->select('value')
        				->get('settings')->first_row();
	}
	
	public function search()
	{
		$searchcode = $this->db->where('varname','searchcode')
									->from('settings')->get()->first_row()->varname;
		return "<h4>Search</h4>".$searchcode."<gcse:search></gcse:search>";
	}
	public function login_partial()
	{
		$this->load->module('users');
		return $this->users->login_partial();
	}
	public function sideMenu()
	{
		$this->load->module('menu/menu');
		return $this->menu->mainmenu('side');	
	}
	public function content($page_id)
	{
		$data['view'] = 'index';
		$page = $this->Model_page->select($page_id);
		if($this->session->userdata('timeago')=='Yes'){
			$page->created_at =timespan(strtotime($page->created_at), time() ) . ' ago' ;
		}
		else{				
			$page->created_at = date($this->session->userdata("datetimeformat"),strtotime($page->created_at));
		}
		
		$data['page'] = $page;
		
		$data_temp = array(
               'hits' => $data['page']->hits + 1,
            );
		$this->db->where('id', $page_id);
		$this->db->update('pages', $data_temp);
		
		$this->load->view("index", $data);
	}	
	public function contentvote()
	{
		$updown = $this->input->get('updown');
		$content = $this->input->get('content');
		$id = $this->input->get('id');
		$user = $this->session->userdata('user_id');
		$newvalue = 0;
		$exists = $this->db->where('content',$content)
							->where('idcontent',$id)
							->where('user_id',$user)
							->select('id')->get('content_votes')->num_rows();
		
		$item = $this->db->where('id', $id)->get('pages')->first_row();
		$newvalue = $item->voteup - $item -> votedown;
		if($exists == 0 ){
			$this->db->insert('content_votes',array('user_id'=>$user,
														'updown' => $updown,
														'content' => $content,
														'idcontent' => $id,
														'user_id' => $this->session->userdata('user_id'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			
			if($updown=='1')
				{
					$item -> voteup = $item -> voteup + 1;
				}
				else {
					$item -> votedown = $item -> votedown + 1;
				}
				
			$this->db->where('id', $id);		
			$data = array(
	               'voteup' => $item -> voteup,
	               'votedown' => $item -> votedown,
	            	);
			$this->db->update('pages', $data);
					
			$newvalue = $item->voteup - $item -> votedown;						
		}		
		echo $newvalue;
	}
}

?>