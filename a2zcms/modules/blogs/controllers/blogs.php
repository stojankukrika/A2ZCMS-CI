<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Blogs extends Website_Controller{

	private $page;
	private $pagecontent;
	function __construct()
    {
        parent::__construct();
        $this->load->language('blogs', $this->session->userdata('lang'));
		$this->load->model(array("Model_blog","Model_blog_category","Model_blog_comment","Model_content_vote"));
		$this->pagecontent = Website_Controller::createSiderContent(0);
	
    }
	 /*function for plugins*/
	function getBlogId(){
		$blog = $this->Model_blog->getall();
		return array('blog' =>$blog);
	}
	function getBlogGroupId(){
		$blog = $this->Model_blog_category->getall();
		return array('blog' =>$blog);
	}
	/*function for website part*/
		
	public function newBlogs($params)
	{
		$param = Website_Controller::splitParams($params);
		$data['newBlogs'] = $this->Model_blog->getAllByParams($param['order'],$param['sort'],$param['limit']);
						
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		$this->load->view('blog_partial',$data);
	}
	public function item($slug='')
	{
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		if($slug=='') {
			$slug = $this->Model_blog->selectFirstSlug();
		}
		$blog= $this->Model_blog->selectBySlug($slug);		
		
		if($this->session->userdata('timeago')=='Yes'){
			$blog->created_at =timespan(strtotime($blog->created_at), time() ) . ' ago' ;
		}
		else{				
			$blog->created_at = date($this->session->userdata("datetimeformat"),strtotime($blog->created_at));
		}	
		$blog->blog_comments = $this->Model_blog_comment->total_rows_blog($blog->id);
		
		$blog_comments = $this->Model_blog_comment->selectAllFromBlog($blog->id);
		foreach ($blog_comments as $item)
		{
			if($this->session->userdata('timeago')=='Yes'){
				$item->created_at =timespan(strtotime($item->created_at), time() ) . ' ago' ;
			}
			else{				
				$item->created_at = date($this->session->userdata("datetimeformat"),strtotime($item->created_at));
			}	
		}
		$data['blog_comments'] = $blog_comments;
		$data['blog'] = $blog;
		
		$this->form_validation->set_rules('comment', "Comment", 'required');
		if ($this->form_validation->run() == TRUE)
        {
        	$this->Model_blog_comment->insert(array('content'=>$this->input->post('comment'),
														'blog_id' => $blog->id,
														'user_id' => $this->session->userdata('user_id'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
        	redirect($this->uri->uri_string());
		}
		$this->load->view('blog',$data);
	}
	public function showBlogs($ids,$grids,$sorts,$limits,$orders)
	{
		$showBlogs = array();
		$ids = rtrim($ids, ",");

		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			
			$showBlogs = $this->Model_blog->selectWhereIn($ids,$orders,$sorts);
		}
		else if($limits!=0) {
			$showBlogs = $this->Model_blog->selectWhereLimit($orders,$sorts,$limits);			
			
		}
		else {}
		$data['showBlogs'] = $showBlogs;
		return $this->load->view('blogs',$data);
	}
	public function contentvote()
	{
		$updown = $this->input->get('updown');
		$content = $this->input->get('content');
		$id = $this->input->get('id');
		$user = $this->session->userdata('user_id');
		
		$exists = $this->Model_content_vote->countVoteForContent($updown,$content,$id,$user);
		if($content=='blog')
		{
			$item = $this->Model_blog->select($id);
		}
		else {
			$item = $this->Model_blog_comment->select($id);
		}
		
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
			if($content=='blog')
			{
				$this->Model_blog->update($data,$id);
			}
			else {
				$this->Model_blog_comment->update($data,$id);
			}
					
			$newvalue = $item->voteup - $item -> votedown;						
		}		
		echo $newvalue;
	}
		
}
?>