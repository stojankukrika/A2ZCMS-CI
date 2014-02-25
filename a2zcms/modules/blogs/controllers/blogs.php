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
	function showBlogs($id)
	{
		echo "Blogs";
	}
	
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
		$data['blog'] = $this->db->limit(1)->where('slug',$slug)->get('blogs')->first_row();;
		$this->load->view('blog',$data);
	}
		
}
?>