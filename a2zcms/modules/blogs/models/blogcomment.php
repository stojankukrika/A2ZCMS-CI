<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class BlogComment extends DataMapper {
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	var $table = "blog_comments";
    public $validation = array(
		'title' => array(
			'content' => array('required', 'trim')
		)
	);
	
}

?>