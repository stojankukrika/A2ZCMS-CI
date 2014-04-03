<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Pages extends Website_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(array("Model_page","Model_content_vote","Model_settings"));
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
		return $this->Model_settings->getSettignsForGroup('title')->varname;
	}
	
	public function search()
	{
		$searchcode = $this->Model_settings->getSettignsForGroup('searchcode')->varname;
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
		$page = $this->Model_page->selectById($page_id);
		$rightpassword = false;
		if($page->password == $this->input->post('pagepass') && $page->id== $this->input->post('pageid')){
			$rightpassword = true;
		}			
		$data['view'] = 'index';
		if($page->password=="" || ($page->password!="" && $rightpassword==true)){
			$data['view'] = 'index';
			if($this->session->userdata('timeago')=='Yes'){
				$page->created_at =timespan(strtotime($page->created_at), time() ) . ' ago' ;
			}
			else{				
				$page->created_at = date($this->session->userdata("datetimeformat"),strtotime($page->created_at));
			}			
			$data['page'] = $page;
			$this->load->view("index", $data);
		}
		else {
			$data['page'] = $page;			
			$this->load->view("protected", $data);
		}
	}	
	public function contentvote()
	{
		$updown = $this->input->get('updown');
		$content = $this->input->get('content');
		$id = $this->input->get('id');
		$user = $this->session->userdata('user_id');
		
		$exists = $this->Model_content_vote->countVoteForContent($updown,$content,$id,$user);
				
		$item = $this->Model_page->select($id);
		$newvalue = $item->voteup - $item -> votedown;
		if($exists == 0 ){
			$this->Model_content_vote->insert(array('user_id'=>$user,
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
					
			$data = array(
	               'voteup' => $item -> voteup,
	               'votedown' => $item -> votedown,
	            	);
			$this->Model_page->update($data,$id);
								
			$newvalue = $item->voteup - $item -> votedown;						
		}		
		echo $newvalue;
	}

	public function change_uilang()
	{
		$old_lang = @$_SESSION['lang'];
		$lang = $this->uri->segment(3);
		if (!valid_lang($lang)) {
			$lang = DEF_LANG;
		}
		$this->session->set_userdata('lang', $lang);
		
		$redirect = $this->input->get('return') ? $this->input->get('return') : $_SERVER['HTTP_REFERER'];
		redirect($redirect);
	}
}

?>