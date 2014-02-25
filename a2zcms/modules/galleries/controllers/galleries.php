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
	function showGalleries($id)
	{
		echo "Gallery";
	}
	
	public function newGallerys($params)
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
		$data['gallery'] = $this->db->limit(1)->where('id',$id)->get('galleries')->first_row();;
		$this->load->view('gallery',$data);
	}
}
?>