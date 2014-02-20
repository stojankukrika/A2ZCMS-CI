<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Blogs extends Website_Controller{

	function __construct()
    {
        parent::__construct();
        $this->load->model(array("Model_blog","Model_blogcategory"));
	
    }
	/*function for plugins*/
	function getBlogId(){
		$blog = $this->Model_blog->getall();
		return array('blog' =>$blog);
	}
	
	function getBlogGroupId(){
		$blog = $this->Model_blogcategory->getall();
		return array('blog' =>$blog);
	}
		
}
?>