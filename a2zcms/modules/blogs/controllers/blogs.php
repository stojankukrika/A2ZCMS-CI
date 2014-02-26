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
        $this->load->model(array("Model_blog","Model_blog_category"));
		$this->page = $this->db->limit(1)->get('pages')->first_row();
		$this->pagecontent = Website_Controller::createSiderContent($this->page->id);
	
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
		$data['newBlogs'] = $this->db->order_by($param['order'],$param['sort'])
						->limit($param['limit'])->select('id, title, slug')->get('blogs')->result();
						
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
			$slug = $this->db->select('slug')->limit(1)->get('blogs')->first_row()->slug;
		}
		$blog= $this->db->limit(1)->where('slug',$slug)->get('blogs')->first_row();
		$blog->created_at = date($this->session->userdata("datetimeformat"),strtotime($blog->created_at));
		$blog->user_id = $this->db->where('id',$blog->user_id)->select('CONCAT(name ,'.'," " ,'.', surname) as fullname', FALSE)->get('users')->first_row()->fullname;
		$data['blog'] = $blog;
		$this->load->view('blog',$data);
	}
	public function showBlogs($ids,$grids,$sorts,$limits,$orders)
	{
		$showBlogs = array();
		$ids = rtrim($ids, ",");

		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			
			$showBlogs = $this->db->where_in('id', $ids)
									->order_by($orders,$sorts)
									->select('id, slug, title, content,image')->get('blogs')->result();
		}
		else if($limits!=0) {
			$showBlogs = $this->db->order_by($orders,$sorts)
								->limit($limits)
								->select('id, slug, title, content, image')->get('blogs')->result();
		}
		$data['showBlogs'] = $showBlogs;
		return $this->load->view('blogs',$data);
	}
		
}
?>