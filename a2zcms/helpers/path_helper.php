<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('file_data_dir')) {
	function file_data_dir() {
		return base_url() . 'data/';
	}

}

if (!function_exists('js_dir')) {
	function js_dir() {
		return base_url() . 'application/views/assets/js/';
	}

}
if (!function_exists('css_dir')) {
	function css_dir() {
		return base_url() . 'application/views/assets/css/';
	}

}

if (!function_exists('img_dir')) {
	function img_dir() {
		return base_url() . 'application/views/assets/img/';
	}

}

function admin_theme_dir() {
	return base_url() . 'application/views/assets/adminpaneltheme/';
}
