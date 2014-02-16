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
		return $blog->select('id,title')->get();
	}
	
	function getBlogGroupId(){
		$blog = new BlogCategory();
		return $blog->select('id,title')->get();
	}
		
}
?>