<?php
/*
Author: Stojan Kukrika
Date: 01/21/14
Version: 1.0
*/

class Galleries extends Website_Controller{

	function __construct()
    {
        parent::__construct();
    }
	/*function for plugins*/
	function getGalleryId(){
		$gallery = new Gallery();
		$gallery->select('id,title')->get();
		return array('gallery' =>$gallery);
	}
}
?>