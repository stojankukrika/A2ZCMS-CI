<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Galleries extends Website_Controller{

	private $page;
	private $pagecontent;
	function __construct()
    {
        parent::__construct();
    	$this->load->model(array("Model_gallery","Model_gallery_image","Model_gallery_image_comment","Model_content_vote"));
		$this->pagecontent = Website_Controller::createSiderContent(0);
	}
	/*function for plugins*/
	function getGalleryId(){
		$gallery = $this->Model_gallery->getall();
		return array('gallery' =>$gallery);
	}

	/*function for website part*/
	
	public function newGallery($params)
	{
		$param = Website_Controller::splitParams($params);
		$newGalleries = $this->Model_gallery->getAllByParams($param['order'],$param['sort'],$param['limit']);
		
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		$data['newGalleries'] = $newGalleries;
		$this->load->view('galleries_partial',$data);
	}
	public function item($id='')
	{
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		if($id=='') {
			$id = $this->Model_gallery->selectFirst();
		}
		$gallery= $this->Model_gallery->selectById($id);
		
		if($this->session->userdata('timeago')=='Yes'){
				$gallery->created_at =timespan(strtotime($gallery->created_at), time() ) . ' ago' ;
			}
		else{				
			$gallery->created_at = date($this->session->userdata("datetimeformat"),strtotime($gallery->created_at));
		}		
		$data['gallery'] = $gallery;
		$data['gallery_images'] = $this->Model_gallery_image->selectgalery($id);
		$this->load->view('gallery',$data);
	}
	
	function showGalleries($ids="",$grids="",$sorts,$limits,$orders)
	{
		$showGallery =array();
		$showImages =array();
		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			$showGallery = $this->Model_gallery->selectWhereIn($ids,$orders,$sorts);
			
			foreach ($ids as $value) {
				$showImages[$value] = $this->Model_gallery_image->selectgalery($value,$this->session->userdata('pageitem'));
			}
			
		}
		else if($limits!=0)
		{
			$showGallery = $this->Model_gallery->selectLimit($limits,$orders,$sorts);
		}
		
		$data['showGallery'] = $showGallery;
		$data['showImages'] = $showImages;
		$this->load->view('galleries',$data);
	}
	
	function galleryimage($gal_id, $image_id)
	{
		$gallery = $this->Model_gallery->select($gal_id);
		$image = $this->Model_gallery_image->selectForId($image_id);
		
		$comments = $this->Model_gallery_image_comment->selectAllFromImage($image_id);
		
		$image->image_comments = $this->Model_gallery_image_comment->total_rows_gallery_image($image_id);
			
		foreach ($comments as $item)
		{
			if($this->session->userdata('timeago')=='Yes'){
				$item->created_at = timespan(strtotime($item->created_at), time() ) . ' ago' ;
			}
			else{				
				$item->created_at = date($this->session->userdata("datetimeformat"),strtotime($item->created_at));
			}
		}	
		$data['gallery'] = $gallery;
		$data['image'] = $image;
		$data['image_comments'] = $comments;
				
		$data['content'] = array(
            'right_content' => $this->pagecontent['sidebar_right'],
            'left_content' => $this->pagecontent['sidebar_left'],
        );
		$this->form_validation->set_rules('comment', "Comment", 'required');
		if ($this->form_validation->run() == TRUE)
        {
        	$this->Model_gallery_image_comment->insert(array('content'=>$this->input->post('comment'),
														'gallery_image_id' => $image_id,
														'gallery_id' => $gal_id,
														'user_id' => $this->session->userdata('user_id'),
														'updated_at' => date("Y-m-d H:i:s"),
														'created_at' => date("Y-m-d H:i:s")));
        	redirect($this->uri->uri_string());
		}
		$this->load->view('galleryimage',$data);
	}

	public function contentvote()
	{
		$updown = $this->input->get('updown');
		$content = $this->input->get('content');
		$id = $this->input->get('id');
		$user = $this->session->userdata('user_id');
		$exists = $this->Model_content_vote->countVoteForContent($updown,$content,$id,$user);		
		
		if($content=='galleryimage')
			{
				$item = $this->Model_gallery_image->select($id);
			}
		else {
				$item = $this->Model_gallery_image_comment->select($id);
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
			if($content=='galleryimage')
			{
				$this->Model_gallery_image->update($data,$id);
			}
			else {				
				$this->Model_gallery_image_comment->update($data,$id);
			}
					
			$newvalue = $item->voteup - $item -> votedown;						
		}		
		echo $newvalue;
	}
	
}
?>