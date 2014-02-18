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
    }
	/*function for plugins*/
	function getBlogId(){
		$blog = new Blog();
		$blog->select('id,title')->get();
		return array('blog' =>$blog);
	}
	
	function getBlogGroupId(){
		$blog = new BlogCategory();
		$blog->select('id,title')->get();
		return array('blog' =>$blog);
	}
		
}
?>