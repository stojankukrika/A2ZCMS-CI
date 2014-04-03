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

function cir2lat($txt) {
	$cir = array("љ", "њ", "е", "р", "т", "з", "у", "и", "о", "п", "ш", "ђ", "а", "с", "д", "ф", "г", "х", "ј", "к", "л", "ч", "ћ", "ж", "џ", "ц", "в", "б", "н", "м", "Љ", "Њ", "Е", "Р", "Т", "З", "У", "И", "О", "П", "Ш", "Ђ", "А", "С", "Д", "Ф", "Г", "Х", "Ј", "К", "Л", "Ч", "Ћ", "Ж", "Џ", "Ц", "В", "Б", "Н", "М");
	$lat = array("lj", "nj", "e", "r", "t", "z", "u", "i", "o", "p", "š", "đ", "a", "s", "d", "f", "g", "h", "j", "k", "l", "č", "ć", "ž", "dž", "c", "v", "b", "n", "m", "Lj", "Nj", "E", "R", "T", "Z", "U", "I", "O", "P", "Š", "Ć", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Č", "Ć", "Ž", "DŽ", "C", "V", "B", "N", "M");

	return str_replace($cir, $lat, $txt);
}
function lat2cir($txt) {
	$cir = array("љ", "њ", "е", "р", "т", "з", "у", "и", "о", "п", "ш", "ђ", "а", "с", "д", "ф", "г", "х", "ј", "к", "л", "ч", "ћ", "ж", "џ", "ц", "в", "б", "н", "м", "Љ", "Њ", "Е", "Р", "Т", "З", "У", "И", "О", "П", "Ш", "Ђ", "А", "С", "Д", "Ф", "Г", "Х", "Ј", "К", "Л", "Ч", "Ћ", "Ж", "Џ", "Ц", "В", "Б", "Н", "М");
	$lat = array("lj", "nj", "e", "r", "t", "z", "u", "i", "o", "p", "š", "đ", "a", "s", "d", "f", "g", "h", "j", "k", "l", "č", "ć", "ž", "dž", "c", "v", "b", "n", "m", "Lj", "Nj", "E", "R", "T", "Z", "U", "I", "O", "P", "Š", "Ć", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Č", "Ć", "Ž", "DŽ", "C", "V", "B", "N", "M");

	return str_replace($lat,$cir,$txt);
}
function checkAndLatinize($txt)
{
    // return $txt; // testing...
    $lang = getTransLang();
    switch($lang)
    {
        case 'hr': 
        case 'bs':
        case 'sr1':
            $out = cir2lat($txt);
        break;
        default: $out = $txt;
    }
    return $out;
}

function getLangsCombo($selected = "", $fld_name = "langs",$null=FALSE)
{
    $CI = & get_instance();
	if($null==TRUE){
		$arr_lang = $CI->config->item('languages');
	}
	else {
	$arr_lang = array_merge(array(''=>'---'),$CI->config->item('languages'));
	}
    return form_dropdown($fld_name, $arr_lang,$selected);
}

/* Get <options> which we will put in select element
* @param string $sel Selected element
* @param array $arrLangsShow List of langs that will be in combo
* @return string
**/
function getLangsOptions($sel = "", $arrLangsShow = array() )
{
    $CI = & get_instance();
    $out = "";
	foreach($CI->config->item('languages') as $k => $v)
	{
	    if( count($arrLangsShow) > 0 && ! in_array($k,$arrLangsShow)){
	        continue;
        }
	    $out .= "<option " . ( $k==$sel ? ' selected ' : "" ) . " value='$k'>$v</option>";
    }
    return $out;
}

function valid_lang($key)
{
	//global $_languages;
	if( ! is_string($key) || trim($key) == ""){
	    return false;
    }
	$CI = &get_instance();
	$_languages = $CI->config->item('languages');
	return isset($_languages[$key]);
}

function trans($key, $forceLang = "") {
    if( $forceLang != ""){
        if( file_exists( APPPATH . 'language/a2zcms/' . $forceLang . '_lang.php')){
            include APPPATH . 'language/a2zcms/' . $forceLang . '_lang.php';
            $out = isset($lang[$key]) ? $lang[$key] : "**no force lang $key***";
        }
    } else {
    	$out = lang($key);
	}
	$lang = $forceLang != "" ? $forceLang : getTransLang();

	if(isset($out) && !empty($out)){
	    return $out;
    } else {
        $out = "*** no_trans($key , $lang )***";
        $tmp = get_included_files();
        log_message("debug", "No trans ($key). Included files: " . print_r($tmp,1));
        return $out;
    }
}
function getTranslatedConfig($key, $val = "") {
	$ci = &get_instance();
	$out = array();
	if (!$ci->config->item($key)) {
		return $out;
	}
	foreach ($ci->config->item($key) as $k => $v) {
		if ($val != "" && $val == $k) {
			return trans($v);
		}
		$out[$k] = trans($v);
	}
	return $out;
}

function getConfigItem($key, $val)
{
    $ci = &get_instance();
    $arr = $ci->config->item($key);
    
    return isset($arr[$val]) ? $arr[$val] : '-';
}

function getFilterComboConfig($item,$selected = '', $translate = FALSE, $fieldName = "")
{
    $ci =& get_instance();
    $name = $fieldName != "" ? $fieldName : $item;
    $html = "<select name='$name'><option value=''>----</option>";
    $arr = $ci->config->item($item);
    foreach($arr as $k=>$v)
    {
        if( $translate ){
            $v = trans($v);
        }
        $html .= "<option " . ($selected==$k ? ' selected ' : '') . " value='$k'>$v</option>";
    }
    $html .= '</select>';
    return $html;
}
function getTransLang() {
	return isset($_SESSION['lang']) ? valid_lang($_SESSION['lang']) ? $_SESSION['lang'] : DEF_LANG : DEF_LANG;
}
function setTransLang($lang)
{
    if( valid_lang($lang)){
        $_SESSION['lang'] = $lang;
    }
    return true;
}
function escapeJavaScriptText($string) 
{ 
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\"))); 
} 

function textToLink($txt)
{
    $link = $txt;
    if(substr($txt,0,7)!='http://'){
        $link = 'http://' . $txt;
    }
    return anchor($link, $txt , ' target="blank" ');
}
