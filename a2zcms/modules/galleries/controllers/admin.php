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
	
	function index(){
		$data['view'] = 'dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $gallery = new Gallery();
        $gallery->where(array('deleted_at' => NULL))->where('user_id',$this->session->userdata('user_id'))
			->select('id,title,views,folderid,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
		foreach ($gallery as $item) {
 			$comments = new GalleryImageComment();		
			$comments->where('gallery_id', $item->id)->where(array('deleted_at' => NULL));
			$item->countcomments = $comments->count();
			
			$images = new GalleryImage();		
			$images->where('gallery_id', $item->id)->where(array('deleted_at' => NULL));
			$item->countimages = $images->count();
			
		 }
		
        if ($offset > $gallery->paged->total_rows) {
            $offset = floor($gallery->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/galleries/index/'),
            'first_url' => site_url('admin/galleries/index/0'),
            'total_rows' => $gallery->paged->total_rows,
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
            'gallery' => $gallery,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}
	function create($id=0)
	{
		$data['view'] = 'create_edit';

		$gallery_edit = "";
		
		if($id>0)
		{
			$gallery_edit = new Gallery();
			$gallery_edit->select('id,title,views,folderid,start_publish,end_publish,created_at')
			->where('id',$id)->get();			
		}
		
		$data['content'] = array('gallery_edit' => $gallery_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('title', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$start_publish = ($this->input->post('start_publish')=='')?date('Y-m-d') : $this->input->post('start_publish');
			$end_publish = ($this->input->post('end_publish')=='')?null : $this->input->post('end_publish');
			
			$gallery = new Gallery();
			if($id==0){
				$gallery->user_id = $this->session->userdata('user_id');
				$gallery->title = $this->input->post('title');	
				$gallery->start_publish = $start_publish;
				$gallery->end_publish = $end_publish;
				$gallery->folderid = sha1($gallery -> title . $gallery -> start_publish);
				$gallery->updated_at = date("Y-m-d H:i:s");										
				$gallery->created_at = date("Y-m-d H:i:s");
				if ($gallery->save()) {
					if (!is_dir(DATA_PATH.'/gallery/'.$gallery->folderid)) {
					    mkdir(DATA_PATH.'/gallery/' . $gallery->folderid, 0777, TRUE);						
					}
					if (!is_dir(DATA_PATH.'/gallery/'.$gallery->folderid.'/thumbs')) {
					    mkdir(DATA_PATH.'/gallery/' . $gallery->folderid.'/thumbs', 0777, TRUE);						
					}
				}
			}
			else {				
				$gallery->where('id', $id)->update(array('title'=>$this->input->post('title'), 
							'start_publish'=>$start_publish, 
							'end_publish'=>$end_publish, 
							'updated_at'=>date("Y-m-d H:i:s")));
			}
        }
    }
	function delete($id)
	{
		$data['view'] = 'delete';
		$data['content'] = array('galleryid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('galleryid', "Title", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('galleryid');
			
			$gallery = new Gallery();
			$gallery->where('id', $id)->where('user_id',$this->session->userdata('user_id'))
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function upload($id)
	{
		$data['view'] = 'upload';
		
		$gallery = new Gallery();
		$gallery->select('title')->where('id',$id)->get();
		$data['content'] = array('gid' => $id,'title'=>$gallery->title);
		
		$this->load->view('adminmodalpage', $data);
	}
	function do_upload()
	{
		   	$id = $this->input->get('gid');
			
        	$gallery = new Gallery();
			$gallery->select('folderid')->where('id',$id)->get();

			$path = DATA_PATH.'/gallery/'. $gallery -> folderid;
			Fineuploader::init($path);

			$name = Fineuploader::getName();

			$info = new SplFileInfo($name);
			$extension = $info -> getExtension();

			$name = sha1($name . $gallery -> folderid . time()) . '.' . $extension;

			$galleryimage = new GalleryImage();
			$galleryimage->gallery_id = $id;
			$galleryimage->content = $name;
			$galleryimage->user_id = $this->session->userdata('user_id');
			$galleryimage->updated_at = date("Y-m-d H:i:s");										
			$galleryimage->created_at = date("Y-m-d H:i:s");
			$galleryimage->save();

			Fineuploader::upload($name);

			$path2 = DATA_PATH.'/gallery/' . $gallery -> folderid . '/thumbs/';
			Fineuploader::init($path2);
			$upload_success = Fineuploader::upload($name);

			Thumbnail::generate_image_thumbnail($path2 . $name, $path2 . $name);
			
			echo json_encode($upload_success);
	}

	/*Gallery comments*/
	
	function galleryimagecomments(){
		$data['view'] = 'galleryimagecomments/dashboard';
		
		$offset = (int)$this->uri->segment(4);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $galleryimagecomment = new GalleryImageComment();
        $galleryimagecomment->where(array('deleted_at' => NULL))->where('user_id',$this->session->userdata('user_id'))
			->select('id,content,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
        if ($offset > $galleryimagecomment->paged->total_rows) {
            $offset = floor($galleryimagecomment->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/galleries/index/'),
            'first_url' => site_url('admin/galleries/index/0'),
            'total_rows' => $galleryimagecomment->paged->total_rows,
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
            'galleryimagecomment' => $galleryimagecomment,
            'offset' => $offset
        );
 
        $this->load->view('adminpage', $data);
	}

	function listcomments($gallery_id){
		$data['view'] = 'galleryimagecomments/listcomments';
		
		$offset = (int)$this->uri->segment(5);
        if (!($offset > 0)) {
            $offset = 0;
        }
        $galleryimagecomment = new GalleryImageComment();
        $galleryimagecomment->where(array('deleted_at' => NULL))
        	->where('gallery_id',$gallery_id)
			->where('user_id',$this->session->userdata('user_id'))
			->select('id,content,created_at')
            ->get_paged($offset, $this->session->userdata('pageitemadmin'), TRUE);
		
		$gallery = new Gallery();
        $gallery->where('id',$gallery_id)
			->select('title')->get();
			
        if ($offset > $galleryimagecomment->paged->total_rows) {
            $offset = floor($galleryimagecomment->paged->total_rows / $this->session->userdata('pageitemadmin')) *
                $this->session->userdata('pageitemadmin');
        }
 
        $pagination_config = array(
            'base_url' => site_url('admin/galleries/listcomments/'.$gallery_id.'/'),
            'first_url' => site_url('admin/galleries/listcomments/'.$gallery_id.'/0'),
            'total_rows' => $galleryimagecomment->paged->total_rows,
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
            'galleryimagecomment' => $galleryimagecomment,
            'offset' => $offset,
            'gallery' => $gallery,
        );
 
        $this->load->view('adminpage', $data);
	}

	function galleryimagecomments_create($id)
	{
		$data['view'] = 'galleryimagecomments/create_edit';

		$gallerycomment_edit = "";
		
		if($id>0)
		{
			$gallerycomment_edit = new GalleryImageComment();
			$gallerycomment_edit->select('id,content,created_at')
			->where('id',$id)->get();			
		}
		
		$data['content'] = array('gallerycomment_edit' => $gallerycomment_edit);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('content', "Content", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$gallerycomment = new GalleryImageComment();
			$gallerycomment->where('id', $id)->update(array('content'=>$this->input->post('content'),
							'updated_at'=>date("Y-m-d H:i:s")));
		}
    }
	function galleryimagecomments_delete($id)
	{
		$data['view'] = 'galleryimagecomments/delete';
		$data['content'] = array('gallerycommentid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('gallerycommentid', "Comment", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('gallerycommentid');
			
			$gallerycomment = new GalleryImageComment();
			$gallerycomment->where('id', $id)->where('user_id',$this->session->userdata('user_id'))
			->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	/*Gallery images*/
	function galleryimages()
	{
		$data['view'] = 'galleryimages/dashboard';

		$gallery = new Gallery();
    	$gallery->where('user_id',$this->session->userdata('user_id'))
				->where(array('deleted_at' => NULL))
				->select('id,title')->get();
 
        $data['content'] = array(
            'gallery' => $gallery,
        );
 
        $this->load->view('adminpage', $data);
		
		/*delete image*/
		$this->form_validation->set_rules('galleryimageid', "Image", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('galleryimageid');
			$galleryimage = new GalleryImage();
			$galleryimage->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function listimages($id)
	{
		$data['view'] = 'galleryimages/listimages';

		$gallery = new Gallery();
    	$gallery->where('user_id',$this->session->userdata('user_id'))
				->where(array('deleted_at' => NULL))->where('id',$id)
				->select('id,title')->get();
 
        $data['content'] = array(
            'gallery' => $gallery,
        );
 
        $this->load->view('adminpage', $data);
		
		/*delete image*/
		$this->form_validation->set_rules('galleryimageid', "Image", 'required');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('galleryimageid');
			$galleryimage = new GalleryImage();
			$galleryimage->where('id', $id)->update(array('deleted_at'=>date("Y-m-d H:i:s")));
        }
	}
	
	function imageforgallery($id)
	{
		$galleryimages = new GalleryImage();
		$galleryimages->select('id,content,voteup,votedown,hits')
						->where(array('deleted_at' => NULL))
						->where('gallery_id',$id)->get();
		
		$gallery = new Gallery();
		$gallery->select('id,folderid')
						->where('id',$id)->get();
						
		$images = array();
		foreach ($galleryimages as $galleryimage) {
			$images[] = array (
					      'id' => $galleryimage->id,
					      'content' => $galleryimage->content,
					      'folderid' =>$gallery->folderid,
					      'voteup' => $galleryimage->voteup,
					      'votedown' => $galleryimage->votedown,
					      'hits' => $galleryimage->hits,
					    );
		}				
		echo json_encode($images);
	}
	function galleryimages_delete($id)
	{
		$data['view'] = 'galleryimages/delete';
		$data['content'] = array('galleryimageid' => $id);
		
		$this->load->view('adminmodalpage', $data);
		
	}
	
	
	/*Install*/
	function install()
	{
		$database = $this->load->database('default', TRUE);	
		$data['view'] = 'install';
		$data['content'] = array();
		if (!empty($_POST))
		{
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."galleries` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `user_id` int(10) unsigned NOT NULL,
						  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
						  `views` int(10) unsigned NOT NULL DEFAULT '0',
						  `folderid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
						  `start_publish` date NOT NULL,
						  `end_publish` date DEFAULT NULL,
						  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `deleted_at` timestamp NULL DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `gallery_user_id_foreign` (`user_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."gallery_images` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `gallery_id` int(10) unsigned NOT NULL,
						  `user_id` int(10) unsigned NOT NULL,
						  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
						  `voteup` int(10) unsigned NOT NULL DEFAULT '0',
						  `votedown` int(10) unsigned NOT NULL DEFAULT '0',
						  `hits` int(10) unsigned NOT NULL DEFAULT '0',
						  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `deleted_at` timestamp NULL DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `gallery_images_gallery_id_foreign` (`gallery_id`),
						  KEY `gallery_images_user_id_foreign` (`user_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "CREATE TABLE IF NOT EXISTS `".$database->dbprefix."gallery_images_comments` (
						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						  `user_id` int(10) unsigned NOT NULL,
						  `gallery_id` int(10) unsigned NOT NULL,
						  `gallery_image_id` int(10) unsigned NOT NULL,
						  `content` text COLLATE utf8_unicode_ci NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
						  `deleted_at` timestamp NULL DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `gallery_images_comments_user_id_foreign` (`user_id`),
						  KEY `gallery_images_comments_gallery_id_foreign` (`gallery_id`),
						  KEY `gallery_images_comments_gallery_image_id_foreign` (`gallery_image_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."galleries`
						  ADD CONSTRAINT `gallery_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`);";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."gallery_images`
						  ADD CONSTRAINT `gallery_images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`) ON DELETE CASCADE,
						  ADD CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `".$database->dbprefix."galleries` (`id`) ON DELETE CASCADE;";
			$this->db->query($query);
			
			$query = "ALTER TABLE `".$database->dbprefix."gallery_images_comments`
						  ADD CONSTRAINT `gallery_images_comments_gallery_image_id_foreign` FOREIGN KEY (`gallery_image_id`) REFERENCES `".$database->dbprefix."gallery_images` (`id`) ON DELETE CASCADE,
						  ADD CONSTRAINT `gallery_images_comments_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `".$database->dbprefix."galleries` (`id`) ON DELETE CASCADE,
						  ADD CONSTRAINT `gallery_images_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `".$database->dbprefix."users` (`id`) ON DELETE CASCADE;";
			$this->db->query($query);
			
			if (!is_dir(CMS_ROOT .'../data/gallery')) {
			    mkdir(CMS_ROOT .'../data/gallery', 0777, TRUE);		
			}	
			/*add to plugins*/
			$data = array(
						   'name' => 'galleries' ,
						   'title' => 'Gallery' ,
						   'function_id' => 'getGalleryId',
						   'function_grid' => NULL,
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
						   'plugin_id' => $this->db->insert_id() ,
						   'icon' => 'icon-camera' ,
						   'order' => 0,
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_navigations', $data);
			$admin_navigation_id = $this->db->insert_id();
			
			/*add to admin subnavigation*/
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Gallery images' ,
						   'url' => 'galleries/galleryimages',
						   'icon' => 'icon-rss',
						   'order' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Galleries' ,
						   'url' => 'galleries',
						   'icon' => 'icon-camera-retro',
						   'order' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
			$data = array(
						   'admin_navigation_id' => $admin_navigation_id ,
						   'title' => 'Gallery comments' ,
						   'url' => 'galleries/galleryimagecomments',
						   'icon' => 'icon-comments-alt',
						   'order' => '3',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('admin_subnavigations', $data);
			
			/*add plugin permission*/
			$data = array(
						   'name' => 'manage_galleries' ,
						   'display_name' => 'Manage galleries' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'manage_gallery_images' ,
						   'display_name' => 'Manage gallery images' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'manage_gallery_imagecomments' ,
						   'display_name' => 'Manage gallery image comments' ,
						   'is_admin' => '1',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'post_gallery_comment' ,
						   'display_name' => 'Post gallery comment' ,
						   'is_admin' => '0',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			$data = array(
						   'name' => 'post_image_vote' ,
						   'display_name' => 'Post image vote' ,
						   'is_admin' => '0',
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('permissions', $data);
			
			/*add plugin function*/
			$data = array(
						   'title' => 'New gallerys' ,
						   'plugin_id' => $plugin_id ,
						   'function' => 'newGallerys',
						   'params' => 'sort:asc;order:id;limit:5;',
						   'type' => 'sidebar',					   
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugin_functions', $data);
			
			$data = array(
						   'title' => 'New gallerys' ,
						   'plugin_id' => $plugin_id ,
						   'function' => 'showGallery',
						   'params' => 'id;sort;order;limit;',
						   'type' => 'content',					   
						   'created_at' => date("Y-m-d H:i:s"),
						   'updated_at' => date("Y-m-d H:i:s"),
						   'deleted_at' => NULL
						   );
			$this->db->insert('plugin_functions', $data);
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
						->where('name','manage_gallery_images')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_gallery_imagecomments')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','post_gallery_comment')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','post_image_vote')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			$permission = $this->db->select('id')
						->from('permissions')
						->where('name','manage_galleries')->get()->first_row();
	
			$this->db->delete('permission_role', array('id' => $permission->id)); 
			
			/*delete permissions*/
			$names = array('manage_gallery_images','manage_gallery_imagecomments','post_gallery_comment','post_image_vote','manage_galleries');
			$this->db->where_in('name', $names);
			$this->db->delete('permissions');
			
			/*delete plugin functions from pages*/
			$plugin_id = $this->db->select('id')
						->from('plugins')
						->where('name','galleries')->get()->first_row();
			
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
					
			/*drop gallery tables*/
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."gallery_images_comments`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."gallery_images`";
			$this->db->query($query);
			
			$query = "DROP TABLE IF EXISTS `".$database->dbprefix."galleries`";
			$this->db->query($query);
			
			
			if (!is_readable(CMS_ROOT .'../data/gallery')) {
			    unlink(CMS_ROOT .'../data/gallery', 0777, TRUE);		
			}	
		}	
	}
	
}