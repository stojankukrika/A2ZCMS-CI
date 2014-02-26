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
		$this->load->model(array("Model_blog","Model_blog_category","Model_blog_blog_category","Model_blog_comment"));
	}
	/*Blog categories*/
	function blogcategorys()
	{
		$data['view'] = 'blogcategory/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/blogcategorys/'),
            'first_url' => site_url('admin/blogs/blogcategorys/0'),
            'total_rows' => $this->Model_blog_category->total_rows(),
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
		$blogcategories = $this->Model_blog_category->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
 
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
			$this->Model_blog_category->delete($id);
        }
	}
	
	function blogcategorys_create($id = 0)
	{
		$data['view'] = 'blogcategory/create_edit';

		$blogcategory_edit = "";
		
		if($id>0)
		{
			$blogcategory_edit = $this->Model_blog_category->select($id);
		}
		
		$data['content'] = array('blogcategory_edit' => $blogcategory_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			if($id==0){
				$this->Model_blog_category->insert(array('title'=>$this->input->post('title'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_blog_category->update(array('title'=>$this->input->post('title'),
														'updated_at' => date("Y-m-d H:i:s")),$id);
			}			
        }
    }

	/*Blogs*/
	function index()
	{
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
       	$blogs = $this->Model_blog->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
		
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/index/'),
            'first_url' => site_url('admin/blogs/index/0'),
            'total_rows' => $this->Model_blog->total_rows(),
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
            'blogs' => $blogs
        );
 
        $this->load->view('adminpage', $data);
	}
	
	function blog_create($id = 0)
	{
		$data['view'] = 'create_edit';

		$blog_edit = array();
		$assignedcategory = array();
		
		if($id>0)
		{
			$blog_edit = $this->Model_blog->select($id);							
			$assignedcategory = $this->Model_blog_blog_category->select($id);
		}
		
		$category = $this->Model_blog_category->getall();
		$data['content'] = array('blog_edit' => $blog_edit, 
								'assignedcategory' =>$assignedcategory,
								'category' => $category);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
			   	
	   	if ($this->form_validation->run() == TRUE)
        {
        	if($_FILES['image']['name']!=""){
				$filename = $_FILES['image']['name'];
				$file = sha1($filename.time()).'.'.pathinfo($filename, PATHINFO_EXTENSION);
				$config['file_name'] = $file;
				$config['upload_path'] = DATA_PATH.'/blog/';
				$config['allowed_types'] = 'gif|jpg|png';
				$this->load->library('upload', $config);
				$this->upload->do_upload('image');
				
				$config_manip['source_image'] = $config['upload_path'].$file;
				$config_manip['new_image'] = DATA_PATH.'/blog/thumbs';
	            $config_manip['maintain_ratio'] = TRUE;
			    $config_manip['create_thumb'] = TRUE;
			    $config_manip['width'] = 150;
			    $config_manip['quality'] = 100;
				$config_manip['height'] = 100;
			    $config_manip['thumb_marker'] = '_thumb';
	            $this->load->library('image_lib', $config_manip);
	            $this->image_lib->resize();
			
			}
			$start_publish = ($this->input->post('start_publish')=='')?date('Y-m-d') : $this->input->post('start_publish');
			$end_publish = ($this->input->post('end_publish')=='')?null : $this->input->post('end_publish');
			
			if($id==0){
				$id = $this->Model_blog->insert(array('user_id'=>$this->session->userdata('user_id'),
												'title'=> $this->input->post('title'),
												'slug'=> url_title( $this->input->post('title'), 'dash', true),
												'resource_link'=> $this->input->post('resource_link'),
												'image'=> $file,
												'content'=>  $this->input->post('content'),
												'start_publish'=> $start_publish,
												'end_publish'=> $end_publish,				
												'updated_at' => date("Y-m-d H:i:s"),
												'created_at' => date("Y-m-d H:i:s")));
			}
			else {
				$this->Model_blog->update(array('title'=> $this->input->post('title'),
												'slug'=> url_title( $this->input->post('title'), 'dash', true),
												'resource_link'=> $this->input->post('resource_link'),
												'image'=> $file,
												'content'=>  $this->input->post('content'),
												'start_publish'=> $start_publish,
												'end_publish'=> $end_publish,
												'updated_at' => date("Y-m-d H:i:s")),$id);
				if($file!=""){						
					$this->Model_blog->update(array('image'=>$file),$id);	
				}
				
				$this->Model_blog_blog_category->delete($id);
					
			}
			$categorys = $this->input->post('category');
			if(!empty($categorys)){
				foreach($categorys as $key => $category_id)
		        {
		        	$this->Model_blog_blog_category->insert(array('blog_category_id'=> $category_id,
																	'blog_id'=> $id,
																	'created_at'=> date("Y-m-d H:i:s"),
																	'updated_at' => date("Y-m-d H:i:s")),$id);
		        }
			}
        }
    }
	
	function blog_delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('blogid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('blogid', "blogid", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('blogid');
			$this->Model_blog->delete($id);
        }
	}	
	
	/*Blog comments*/
	function blogcomments()
	{
		$data['view'] = 'blogcomments/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
		$blogcomments = $this->Model_blog_comment->fetch_paging($this->session->userdata('pageitemadmin'),$offset);
 	
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/blogcategorys/'),
            'first_url' => site_url('admin/blogs/blogcategorys/0'),
            'total_rows' => $this->Model_blog_comment->total_rows(),
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
            'blogcomments' => $blogcomments,
        );
 
        $this->load->view('adminpage', $data);
	}

	function listcommentsforblog($id)
	{
		$data['view'] = 'blogcomments/listcommentsforblog';
		
		$offset = (int)$this->uri->segment(5);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $blogcomments = $this->Model_blog_comment->fetch_paging_blog($this->session->userdata('pageitemadmin'),$offset,$id);
		$blog = $this->Model_blog->select($id);
		
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/listcommentsforblog/'+$id+'/'),
            'first_url' => site_url('admin/blogs/listcommentsforblog/'+$id+'/0'),
            'total_rows' => $this->Model_blog_comment->total_rows($id),
            'per_page' => $this->session->userdata('pageitemadmin'),
            'uri_segment' => 5,
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
            'blogcomments' => $blogcomments,
            'blog' =>$blog
        );
 
        $this->load->view('adminpage', $data);
	}

	function blogcomments_delete($id)
	{
		$data['view'] = 'blogcategory/delete';
		$data['content'] = array('blogcategoryid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('blogcategoryid', "blogcategoryid", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('blogcategoryid');
			$this->Model_blog_comment->delete($id);
        }
	}
	
	/*Install*/
	function install()
	{
		$database = $this->load->database('default', TRUE);	
		$data['view'] = 'install';
		$data['content'] = array();
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."blogs` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `user_id` int(10) unsigned NOT NULL,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `content` text COLLATE utf8_unicode_ci NOT NULL,
					  `voteup` int(10) unsigned NOT NULL DEFAULT '0',
					  `votedown` int(10) unsigned NOT NULL DEFAULT '0',
					  `hits` int(10) unsigned NOT NULL DEFAULT '0',
					  `start_publish` date NOT NULL,
					  `end_publish` date DEFAULT NULL,
					  `resource_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
					  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `blogs_user_id_foreign` (`user_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."blog_blog_categories` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `blog_id` int(10) unsigned NOT NULL,
					  `blog_category_id` int(10) unsigned NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `blog_blog_categories_blog_id_index` (`blog_id`),
					  KEY `blog_blog_categories_blog_category_id_index` (`blog_category_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."blog_categories` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."blog_comments` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `user_id` int(10) unsigned NOT NULL,
					  `blog_id` int(10) unsigned NOT NULL,
					  `content` text COLLATE utf8_unicode_ci NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `blog_comments_user_id_foreign` (`user_id`),
					  KEY `blog_comments_blog_id_foreign` (`blog_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."blogs`
					  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`);";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."blog_blog_categories`
					  ADD CONSTRAINT `blog_blog_categories_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `".$database->dbprefix."blog_categories` (`id`) ON DELETE CASCADE,
					  ADD CONSTRAINT `blog_blog_categories_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `".$database->dbprefix."blogs` (`id`) ON DELETE CASCADE;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."blog_comments`
					  ADD CONSTRAINT `blog_comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `".$database->dbprefix."blogs` (`id`) ON DELETE CASCADE,
					  ADD CONSTRAINT `blog_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`) ON DELETE CASCADE;";			
			$this->db->query($query);
			
			if (!is_dir(CMS_ROOT .'../data/blog')) {
			    mkdir(CMS_ROOT .'../data/blog', 0777, TRUE);		
			}	
			if (!is_dir(CMS_ROOT .'../data/blog/thumbs')) {
			    mkdir(CMS_ROOT .'../data/blog/thumbs', 0777, TRUE);		
			}
			
			/*add to plugins*/
			$data = array(
						   'name' => 'blogs' ,
						   'title' => 'Blog' ,
						   'function_id' => 'getBlogId', 
						   'function_grid' => 'getBlogGroupId',
						   'can_uninstall' => '1',
						   'pluginversion' => '1.0',
						   'active' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugins', $data);
			$plugin_id = $this->db->insert_id();
			
			/*add to admin root navigation*/
			$data = array(
						   'plugin_id' => $plugin_id ,
						   'icon' => 'icon-external-link' ,
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data);
			$admin_navigation_id = $this->db->insert_id();
			
			/*add plugin permission*/
			$data = array(
						   'name' => 'manage_blogs' ,
						   'display_name' => 'Manage blogs' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'manage_blog_categris' ,
						   'display_name' => 'Manage blog categris' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'post_blog_comment' ,
						   'display_name' => 'Post blog comment' ,
						   'is_admin' => '0',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'post_blog_vote' ,
						   'display_name' => 'Post blog vote' ,
						   'is_admin' => '0',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			/*add plugin function*/
			$data = array(
						   'title' => 'New blogs' ,
						   'plugin_id' => $plugin_id,
						   'function' => 'newBlogs',
						   'params' => 'sort:asc;order:id;limit:5;',
						   'type' => 'sidebar',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugin_functions', $data);
			
			$data = array(
						   'title' => 'Display blogs' ,
						   'plugin_id' => $plugin_id,
						   'function' => 'showBlogs',
						   'params' => 'id;sort;order;limit;',
						   'type' => 'content',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugin_functions', $data);
			
			
			/*add admin subnavigation*/
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Blog categorys' ,
						   'url' => 'blogs/blogcategorys',
						   'icon' => 'icon-rss',
						   'order' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Blog' ,
						   'url' => 'blogs',
						   'icon' => 'icon-book',
						   'order' => '2',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Blog comments' ,
						   'url' => 'blogs/blogcomments',
						   'icon' => 'icon-comment-alt',
						   'order' => '3',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
		}
	}
	/*Uninstall*/
	function uninstall()
	{
		$database = $this->load->database('default', TRUE);				
		$data['view'] = 'uninstall';
		$data['content'] = array();
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('plugin', "plugin", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {		
			/*delete permissions from roles*/
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_blogs')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_blog_categris')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','post_blog_comment')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$names = array('manage_blogs','manage_blog_categris','post_blog_comment','post_blog_vote');
			$this->db->where_in('name', $names);
			$this->db->delete('permissions');
			
			/*delete plugin functions from pages*/
			$plugin_id = $this->db->select('id')
						->from('plugins')
						->where('name','blogs')->get()->first_row();
			
			$plugins = $this->db->select('id')
						->from('plugin_functions')
						->where('plugin_id',$plugin_id->id)->get()->result();
						
			foreach ($plugins as $item) {
					$data = array(
			               'deleted_at' => date("Y-m-d H:i:s")
			            );		
					$this->db->where('plugin_function_id', $item->id);
					$this->db->update('page_plugin_functions', $data); 
			}		
			
			/*delete plugin functions*/			
			$this->db->delete('plugin_functions', array('plugin_id' => $plugin_id->id)); 
			
			/*delete admin navigation*/			
			$navigation = $this->db->select('admin_navigations', array('plugin_id' => $plugin_id->id));
			
			$this->db->delete('admin_subnavigations', array('admin_navigation_id' => $navigation->id));			
			$this->db->delete('admin_navigations', array('id' => $navigation->id)); 	
			
			/*delete plugin*/
			$this->db->delete('plugins', array('id' => $plugin_id->id)); 
					
			/*drop blog tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blog_comments`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blog_blog_categories`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blog_categories`";
			$this->db->query($query);
					
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blogs`";
			$this->db->query($query);
			
			if (!is_readable(CMS_ROOT .'../data/blog')) {
			    unlink(CMS_ROOT .'../data/blog', 0777, TRUE);		
			}	
		}
	}
	
}