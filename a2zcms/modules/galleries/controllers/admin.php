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
		$data['content'] = array('galleryid' => $id,'title'=>$gallery->title);
		
		$this->load->view('adminmodalpage', $data);
		
		$this->form_validation->set_rules('gid', "Selected gallery", 'required|integer');
		$this->form_validation->set_rules('qqfile', "Upload file", 'required|image|max:3000');
	   	if ($this->form_validation->run() == TRUE)
        {
        	$id = $this->input->post('gid');
			
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
			
			return json_encode("true");
        }
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

}