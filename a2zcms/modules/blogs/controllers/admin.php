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
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $blogs = new Blog();
		
        $blogs->where(array('deleted_at' => NULL))->where('user_id',$this->session->userdata('user_id'))
			->select('id,title,voteup,votedown,hits,start_publish,end_publish,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
		foreach ($blogs as $item) {
 			$blogs->countcomments = 0;
 			$blogcomment = new BlogComment();		
			$blogcomment->where('blog_id', $item->id);
			$item->countcomments = $blogcomment->count();
		 }
		
        if ($offset > $blogs->paged->total_rows) {
            $offset = floor($blogs->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/index/'),
            'first_url' => site_url('admin/blogs/index/0'),
            'total_rows' => $blogs->paged->total_rows,
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
            'blogs' => $blogs,
            'offset' => $offset
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
			$blog_edit = new Blog();
			$blog_edit->select('id,user_id,title,content,start_publish,end_publish,resource_link,image,created_at') 
							->where('id',$id)
							->where(array('deleted_at' => NULL))
							->get();
							
			$assignedcategory = new BlogBlogCategory();
			$assignedcategory->select('blog_category_id as id') 
							->where('blog_id',$id)
							->where(array('deleted_at' => NULL))
							->get();
		}
		
		$category = new BlogCategory();
		$category->select('id,title')->where(array('deleted_at' => NULL))->get();
							
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
			
        	$blog = new Blog();
			if($id==0){
				$blog->user_id = $this->session->userdata('user_id');
				$blog->title = $this->input->post('title');
				$blog->slug = url_title( $this->input->post('title'), 'dash', true);
				$blog->resource_link = $this->input->post('resource_link');
				$blog->image = $file;
				$blog->content = $this->input->post('content');
				$blog->start_publish= $start_publish;
				$blog->end_publish= $end_publish;	
				$blog->updated_at = date("Y-m-d H:i:s");										
				$blog->created_at = date("Y-m-d H:i:s");
				$blog->save();
				$id = $blog->id;
			}
			else {				
				$blog->where('id',$id)
						->update(array(
									'title'=>$this->input->post('title'), 
									'slug' => url_title( $this->input->post('title'), 'dash', true),
									'resource_link'=>$this->input->post('resource_link'), 
									'content'=>$this->input->post('content'),
									'start_publish'=>$start_publish,
									'end_publish'=>$end_publish,
									'updated_at'=>date("Y-m-d H:i:s")));
				
				if($file!=""){						
					$blog->where('id',$id)
							->update(array('image'=>$file));	
				}			
				$ar = new BlogBlogCategory();
				$ar->where('blog_id', $id)->update('deleted_at', date("Y-m-d H:i:s"));
			}
			$categorys = $this->input->post('category');
			if(!empty($categorys)){
				foreach($categorys as $key => $category_id)
		        {
		        	$ar = new BlogBlogCategory();
		        	$ar->blog_category_id = $category_id;
					$ar->blog_id = $id;
					$ar->created_at = date("Y-m-d H:i:s");
					$ar->updated_at = date("Y-m-d H:i:s");
					$ar->save();			
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
			
			$blog = new Blog();
			$blog->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
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
        $blogcomments = new BlogComment();
		
        $blogcomments->where(array('deleted_at' => NULL))
			->select('id,content,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $blogcomments->paged->total_rows) {
            $offset = floor($blogcomments->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/blogcategorys/'),
            'first_url' => site_url('admin/blogs/blogcategorys/0'),
            'total_rows' => $blogcomments->paged->total_rows,
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
            'offset' => $offset
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
        $blogcomments = new BlogComment();
		$blog = new Blog();
		
        $blogcomments->where(array('deleted_at' => NULL))->where('blog_id',$id)
			->select('id,content,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);

        if ($offset > $blogcomments->paged->total_rows) {
            $offset = floor($blogcomments->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 		
		$blog->select('title')->where('id',$id)->get();
		
        $pagination_config = array(
            'base_url' => site_url('admin/blogs/listcommentsforblog/'+$id+'/'),
            'first_url' => site_url('admin/blogs/listcommentsforblog/'+$id+'/0'),
            'total_rows' => $blogcomments->paged->total_rows,
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
            'offset' => $offset,
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
			
			$blogcategory = new BlogCategory();
			$blogcategory->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function blogcomments_create($id)
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
	
	/*Install*/
	function install()
	{
		$database = $this->load->database('default', TRUE);	
		$data['view'] = 'install';
		$data['content'] = array();
		if (!empty($_POST))
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
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."blog_blog_categorys` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `blog_id` int(10) unsigned NOT NULL,
					  `blog_category_id` int(10) unsigned NOT NULL,
					  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `deleted_at` timestamp NULL DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  KEY `blog_blog_categorys_blog_id_index` (`blog_id`),
					  KEY `blog_blog_categorys_blog_category_id_index` (`blog_category_id`)
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
			
			$query = "ALTER TABLE `".$database->dbprefix."blog_blog_categorys`
					  ADD CONSTRAINT `blog_blog_categorys_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `".$database->dbprefix."blog_categories` (`id`) ON DELETE CASCADE,
					  ADD CONSTRAINT `blog_blog_categorys_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `".$database->dbprefix."blogs` (`id`) ON DELETE CASCADE;";
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
		}
	}
	/*Uninstall*/
	function uninstall()
	{
		$database = $this->load->database('default', TRUE);				
		$data['view'] = 'uninstall';
		$data['content'] = array();
		if (!empty($_POST))
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
			$names = array('manage_blogs','manage_blog_categris','post_blog_comment');
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
			
			/*delete plugin*/
			$this->db->delete('plugins', array('id' => $plugin_id->id)); 
					
			/*drop blog tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blog_comments`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."blog_blog_categorys`";
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