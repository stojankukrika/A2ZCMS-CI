<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('remove_dir')) {
	// Function for remove dir
	function remove_dir($path) {
		if (file_exists($path) && is_dir($path))
			rmdir($path);
	}
}

if (!function_exists('make_dir')) {
	// Functuin to make dir
	function make_dir($path) {
		$subdir = "";
		$arrPath = explode('/', $path);
		foreach ($arrPath as $dir) {
			$subdir .= "$dir" . '/';
			if (!file_exists($subdir)) {
				mkdir($subdir);
				chmod($subdir, 0777);
			}
		}
	}
}

if (!function_exists('valid_password')) {
	// Funtion to chech is valid password
	function valid_password($pwd) {
		if (!$pwd)
			return FALSE;
		if (strlen($pwd) < 6)
			return FALSE;
		if (!preg_match('/[a-zA-Z]+/', $pwd) || !preg_match('/[0-9]+/', $pwd))
			return FALSE;
		return TRUE;
	}
}

if (!function_exists('valid_mail')) {
	// Funtion to chech is valid email
	function valid_mail($str) {
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}
}
if (!function_exists('date_mysql2html')) {
	// Funtion to return formated date
	function date_mysql2html($date, $returnTime = true) {
	    if( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $date)){
	        return $date;
	    }
		$y = substr($date, 0, 4);
		$m = substr($date, 5, 2);
		$d = substr($date, 8, 2);
		$time = substr($date, 11, 5);
		$sep = '.';
		return $d . $sep . $m . $sep . $y . ($returnTime ?  ' ' . $time : "");
	}
}
if (!function_exists('safe_filename')) {
	// Funtion to return safe_filename
	function safe_filename($str) {
		$arrRepl = array('č' => 'c', 'Č' => 'C', 'ć' => 'c', 'Ć' => 'C', 'Ž' => 'Z', 'ž' => 'z', 'đ' => 'dj', 'Đ' => 'Dj', 'š' => 's', 'Š' => 'S', );
		$str = strtr($str, $arrRepl);
		$str = preg_replace('#[^\w\d.]+#', '_', $str);
		return $str;
	}
}
if (!function_exists('is_logged_in')) {
	function is_logged_in(){
		return modules::run("users/_is_logged_in");	
	}
}
if (!function_exists('_is_admin')) {
	function _is_admin(){
		return modules::run("users/_is_admin");	
	}
}
