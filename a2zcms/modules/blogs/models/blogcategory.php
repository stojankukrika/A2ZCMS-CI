<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class BlogCategory extends DataMapper {
	
	function __construct($id = NULL)
    {
        parent::__construct($id);
    }
	var $table = "blog_categories";
    public $validation = array(
		'title' => array(
			'rules' => array('required', 'trim', 'max_length' => 255)
		)
	);
	
}

?>