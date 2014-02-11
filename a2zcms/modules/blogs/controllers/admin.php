<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------

class Admin extends Administrator_Controller {

	function __construct()
	{
		parent::__construct();
	}
	/*Blog categories*/
	function blogcategorys()
	{
		$data['view'] = 'blogcategory/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $blogcategories = new BlogCategory();
		
        $blogcategories->where(array('deleted_at' => NULL))
			->select('id,title,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $blogcategories->paged->total_rows) {
            $offset = floor($blogcategories->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/blogcategorys/'),
            'first_url' => site_url('admin/blogs/blogcategorys/0'),
            'total_rows' => $blogcategories->paged->total_rows,
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 4,
           	'full_tag_open' => '<ul class="pagination">',
			'first_tag_open' => '<li>',
			'first_link' => '<span class="icon-fast-backward"></span>',
		    'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_link' => '<span class="icon-fast-forward"></span>',
			'last_tag_close' => '</li>',
			'next_tag_open' => '<li>',
			'next_link' => '<span class="icon-step-forward"></span>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_link' => '<span class="icon-step-backward"></span>',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a>',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'full_tag_close' => '</ul>',
        );
		
		
        $this->pagination->initialize($pagination_config);
 
        $data['content'] = array(
            'pagination' => $this->pagination,
            'blogcategories' => $blogcategories,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	function blogcategorys_delete($id)
	{
		$data['view'] = 'blogcategory/delete';
		$data['content'] = array('blogcategoryid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('blogcategoryid', "blogcategoryid", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('blogcategoryid');
			
			$blogcategory = new BlogCategory();
			$blogcategory->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function blogcategorys_create($id = 0)
	{
		$data['view'] = 'blogcategory/create_edit';

		$blogcategory_edit = "";
		
		if($id>0)
		{
			$blogcategory_edit = new BlogCategory();
			$blogcategory_edit->select('title')->where('id',$id)->get();
		}
		
		$data['content'] = array('blogcategory_edit' => $blogcategory_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			$blogcategory = new BlogCategory();
			if($id==0){
				$blogcategory->title = $this->input->post('title');
				$blogcategory->updated_at = date("Y-m-d H:i:s");										
				$blogcategory->created_at = date("Y-m-d H:i:s");
				$blogcategory->save();
				$id = $blogcategory->id;
			}
			else {
				
				$blogcategory->where('id', $id)->update(array('title'=>$this->input->post('title'), 
							'updated_at'=>date("Y-m-d H:i:s")));
			}			
        }
    }

	/*Blogs*/
	function index()
	{
		echo "Index/Blog";
		die();
	}
	/*Blog comments*/

}