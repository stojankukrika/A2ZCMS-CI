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
    	$this->load->model(array("Model_gallery","Model_gallery_image","Model_gallery_image_comment"));
		$this->page = $this->db->limit(1)->get('pages')->first_row();
		$this->pagecontent = Website_Controller::createSiderContent($this->page->id);
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
		$newGalleries = $this->db->order_by($param['order'],$param['sort'])
						->limit($param['limit'])->select('id, title')->get('galleries')->result();
						
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
			$id = $this->db->select('id')->limit(1)->get('galleries')->first_row()->id;
		}
		$data['gallery'] = $this->db->limit(1)->where('id',$id)->get('galleries')->first_row();
		$data['gallery_images'] = $this->db->where('gallery_id',$id)->get('gallery_images')->result();
		$this->load->view('gallery',$data);
	}
	
	function showGalleries($ids="",$grids="",$sorts,$limits,$orders)
	{
		$showGallery =array();
		$showImages =array();
		if($ids!="" && $grids==""){
			$ids = rtrim($ids, ",");
			$ids = explode(',', $ids);
			$showGallery = $this->db->where('start_publish <=','CURDATE()')
									->where('(end_publish IS NULL OR end_publish >= CURDATE())')
									->where_in('id', $ids)
									->order_by($orders,$sorts)
									->select('id, title, folderid')->get('galleries')->result();
			foreach ($ids as $value) {
				$showImages[$value] = $this->db->where('gallery_id', $value)->select('id, content')->get('gallery_images')->result();
			}
			
		}
		else if($limits!=0)
		{
			$showGallery = $this->db->where('start_publish <=','CURDATE()')
									->where('(end_publish IS NULL OR end_publish >= CURDATE())')
									->orderBy($orders,$sorts)
									->take($limits)
									->select('id','title','folderid')->get('galleries')->result();
		}
		
		$data['showGallery'] = $showGallery;
		$data['showImages'] = $showImages;
		$this->load->view('galleries',$data);
	}
	
}
?>