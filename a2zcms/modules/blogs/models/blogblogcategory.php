<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class BlogBlogCategory extends DataMapper {
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	var $table = "blog_blog_categorys";
	
	
}

?>