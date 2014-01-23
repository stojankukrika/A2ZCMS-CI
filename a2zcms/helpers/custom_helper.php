<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('get_template_array')) {
	function get_template_array() {
		return array('subheader_content' => array('view' => '', 'data' => ''), 
					'left_content' => array(), 
					'center_content' => array('view' => '', 'data' => ''), 
					'title' => 'Zdici', );
	}
}

if (!function_exists('load_main_template')) {
	function load_main_template($data) {
		$CI = &get_instance();
		$data['meta_keywords'] = $data['meta_description'] = $data['meta_img'] = "";
		$data['meta_title'] = "Zdici - vijesti, novosti, forum, foto...";
		
		$left_content = '';
		if (is_array($data['left_content'])) {
			if (isset($data['left_content_data'])) {
				$dataLeft = $data['left_content_data'];
			} else {
				$dataLeft = array();
			}
			foreach ($data['left_content'] as $view) {
				$left_content .= $CI->load->view($view, $dataLeft, TRUE);
			}
		} else {
			$left_content = $data['left_content'];
		}

		$center_content = '';
		if (!array_key_exists('view', $data['center_content'])) {
			foreach ($data['center_content'] as $data_view) {
				$center_content .= $CI->load->view($data_view['view'], $data_view['data'], TRUE);
			}
		} else {
			$center_content = $CI->load->view($data['center_content']['view'], $data['center_content']['data'], TRUE);
		}
		$footer_sections = array( 1 => 'O nama'); 
		$CI->load->model('Model_section');
		$footer_sections = $CI->Model_section->getSectionsForPortalPosition(SECTION_POSITION_FOOTER);
		$footer_sections_text = $CI->Model_section->getSectionsForPortalPosition(SECTION_POSITION_FOOTER_TEXT);
		//dump($footer_sections);
		$view = array(
		  'left_content' => $left_content,
		  'center_content' => $center_content,
		  'footer_sections' => $footer_sections,
		  'footer_sections_text' => $footer_sections_text,
	    );
        if($isFrame){
            $tmpConf = $CI->uri->segment(3);
            $CI->load->view('desktop/site_template_frame', array(
                'content' => $center_content,
                'confnum_id' => $tmpConf,
            ));
        } else {
        		// Ucitavanje standardnog View templejta sa sadrzajem prikupljenim iz vise fajlova
    		$out = $CI->load->view('desktop/site_template', $view,true);
            if( getTransLang()=='sr1'){
                $out = cir2lat($out);
            }
    		echo $out;
    		// Ucitavanje podnozja
    		$out = $CI->load->view('desktop/site_footer',$view,true);
            if( getTransLang()=='sr1'){
                $out = cir2lat($out);
            }
    		echo $out;
		}
	}

}

function load_full_width_template($data) {
	$CI = &get_instance();
	$data['ui_lang'] = $CI->session->userdata('lang');
	$CI->load->view('desktop/site_header', $data);
	$view = array('content' => $CI->load->view($data['content']['view'], $data['content']['data'], TRUE));
	$CI->load->view('desktop/site_template_full_width', $view);
	$CI->load->view('desktop/site_footer');
}

if (!function_exists('remove_dir')) {
	// Funkcija koja uklanja folder
	function remove_dir($path) {
		if (file_exists($path) && is_dir($path))
			rmdir($path);
	}

}

if (!function_exists('make_dir')) {
	// Funkcija koja kreira folder
	function make_dir($path) {
		$subdir = "";
		$arrPath = explode('/', $path);
		foreach ($arrPath as $dir) {
			$subdir .= "$dir" . '/';
			//echo $subdir;
			if (!file_exists($subdir)) {
				mkdir($subdir);
				chmod($subdir, 0777);
			}
		}
	}

}

if (!function_exists('options')) {
	// Funkcija koja generise niz <option> elemenata za padajucu listu
	function options($data, $selected = '') {
		$html = '';
		foreach ($data as $id => $value) {
			$sel = $selected == $id ? ' selected ' : '';
			$html .= '<option ' . $sel . ' value="' . $id . '">' . $value . '</option>';			
		}
		return $html;
	}

}

if (!function_exists('random_password')) {
	// Funkcija za generisanje slucajnog passworda, kao predlog pri registraciji
	function random_password() {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyz_-';
		$str = '';
		for ($i = 0; $i < 10; $i++) {
			$rand_key = rand(0, strlen($chars) - 1);
			$str .= $chars[$rand_key];
		}
		return $str;
	}

}

if (!function_exists('set_flash_message')) {
	// Funkcija pomocu koje se postavlja flash poruka za korisnika
	function set_flash_message($title, $message, $type = 'success') {
		$CI = &get_instance();
		$CI->session->set_flashdata('flash_message', array('type' => $type, 'title' => $title, 'text' => $message));
	}
}

if (!function_exists('flash_message')) {
	// Funkcija koja prikazuje poruku korisniku
	function flash_message($message = '') {
		$CI = &get_instance();
		if (empty($message))
			$message = $CI->session->flashdata('flash_message');
		$html = '';
		if (is_array($message))
			$html .= $CI->load->view('desktop/flash_message', $message, TRUE);
		return $html;
	}

}

function message_success($msg) {
	return '<div class="success">' . $msg . '</div>';
}

function valid_password($pwd) {
	if (!$pwd)
		return FALSE;
	//if(preg_match('/[^a-zA-Z0-9\-_]+/i' , $pwd))  return FALSE;
	if (strlen($pwd) < 6)
		return FALSE;
	//if( ! preg_match('/[a-z]+/' , $pwd) || ! preg_match('/[A-Z]+/' , $pwd) || ! preg_match('/[0-9]+/',$pwd) ) return FALSE;
	if (!preg_match('/[a-zA-Z]+/', $pwd) || !preg_match('/[0-9]+/', $pwd))
		return FALSE;

	return TRUE;
}

function valid_mail($str) {
	//copied from CI validation class:
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function valid_required($val) {
	if (!is_array($val)) {
		return (trim($val) == '') ? FALSE : TRUE;
	} else {
		return (!empty($val));
	}
}

function create_checkbox_list($arr, $name, $arrChecked = array()) {
	$html = '';

	foreach ($arr as $k => $v) {
		$checked = in_array($k, $arrChecked) ? ' checked ' : '';
		$html .= "<input type='checkbox' name='$name' value='$k' class='dyn_checkbox' $checked > $v <br> ";
	}
	return $html;
}

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
function send_mail($to, $subject, $msg, $data = array()) {
	// Avoid throwing exception when on localhost
	if (preg_match('/localhost/', base_url())) {
		return TRUE;
	}
	$ci = &get_instance();

	$ci->load->library('my_mailer');
	$ci->my_mailer->send_mail($to, $subject, $msg);
}

function safe_filename($str) {
	$arrRepl = array('č' => 'c', 'Č' => 'C', 'ć' => 'c', 'Ć' => 'C', 'Ž' => 'Z', 'ž' => 'z', 'đ' => 'dj', 'Đ' => 'Dj', 'š' => 's', 'Š' => 'S', );
	$str = strtr($str, $arrRepl);
	$str = preg_replace('#[^\w\d.]+#', '_', $str);
	return $str;
}

if (!function_exists('load_admin_template')) {
	// Funkcija koja za niz opisan u prethodnoj funkciji ucitavana View fajlove
	function load_admin_template($data) {
		$CI = &get_instance();
		$CI->load->model('Model_user');
		$CI->load->model('Model_role');

		// Header - obavezan dio za svaku stranicu portala
		$data['ui_lang'] = $CI->session->userdata('lang');
		$CI->load->view('desktop/site_header_new', $data);

		// Ako postoji subheader sadrzaj, ucitava i njega
		if (!empty($data['subheader_content']['view'])) {
			$CI->load->view($data['subheader_content']['view'], $data['subheader_content']['data']);
		}

		// Ucitavanje lijevog sadrzaja, koji moze da se sastoji iz proizvoljnog broja View fajlova
		$left_content = '';
		if (is_array($data['left_content'])) {
			foreach ($data['left_content'] as $view) {
				$left_content .= $CI->load->view($view, '', TRUE);
			}
		} else {
			$left_content = $data['left_content'];
		}
		$center_content = '';
		// Posto je sredisnji dio gotovo uvijek sacinjen iz vise View fajlova, moram da provjerim
		// Da li sadrzi jedan ili view View fajlova
		if (!array_key_exists('view', $data['center_content'])) {
			foreach ($data['center_content'] as $data_view) {
				$center_content .= $CI->load->view($data_view['view'], $data_view['data'], TRUE);
			}
		} else {
			$center_content = $CI->load->view($data['center_content']['view'], $data['center_content']['data'], TRUE);
		}

        //
        $allUserRoles = $CI->Model_role->getAllUserRoles();
		$userGlobalRole = $CI->Model_user->getUserGlobalRole($CI->session->userdata('user_id'));
		$arrConfs = $CI->Model_user->getConferenceForUserAndRole($CI->session->userdata('user_id'), $userGlobalRole);

		$selectedConfName = $CI->session->userdata('conf_name');
		$selectedConfID = $CI->session->userdata('conf_id');
		if( empty($selectedConfName) || $selectedConfID < 1){
		    $CI->Model_user->setLastConfToSelected($arrConfs);
	    }

		$view = array(
    		'left_content' => $left_content,
    		'center_content' => $center_content, 
//    		'roles' => $CI->Model_role->get_user_roles($CI->session->userdata('user_id'), $CI->session->userdata('conf_id'),$userGlobalRole),
    		'roles' => $allUserRoles,
    		'langs' => array('sr1' => 'Lat', 'sr' => 'Ћир', 'en' => 'Eng'), 
    		'confs' => $arrConfs,
    		'name_surname' => $CI->session->userdata('user_full_name'),
    		'conf_name' => $CI->session->userdata('conf_name'),
		);

		// Ucitavanje standardnog View templejta sa sadrzajem prikupljenim iz vise fajlova
		$CI->load->view('desktop/site_template_new', $view);
		// Ucitavanje podnozja
		$CI->load->view('desktop/site_footer_new');
	}

}

if (!function_exists('user_menu')) {
	// Funkcija koja vraca HTML kod za meni korisnika baziran na ulogama na aktivnoj konferenciji
	function user_menu($show_conf_chooser = false, $show_role_chooser = false) {
		$CI = &get_instance();
		$CI -> load -> model(array('Model_user', 'Model_role'));
		$menu = '';
		$cid = $CI -> session -> userdata('conf_id');
		if ($CI -> session -> userdata('user_id') > 0) {
			$base_menu = user_profile_badge();
			if ($show_role_chooser){
				$base_menu .= role_chooser();
			}
			if ($show_conf_chooser){
				$base_menu .= conf_chooser();
			}
			$menu = $base_menu;
			// Postavlja osnovni meni, koji ima svaki korisnik, bez obzira na uloge
			$conf_id = $CI -> session -> userdata('conf_id');
			$role_id = $CI -> session -> userdata('role_id');
			/*
			if (empty($conf_id)){
				return $menu;
			}
			*/
			if ($role_id == $CI -> Model_role -> ADMIN){
				$menu .= $CI -> load -> view('desktop/user/menus/admin', '', TRUE);
			} else if ($role_id == $CI -> Model_role -> REVIEWER){
				$menu .= $CI -> load -> view('desktop/user/menus/reviewer', '', TRUE);
			} else if ($role_id == $CI -> Model_role -> AUTHOR){
				$menu .= $CI -> load -> view('desktop/user/menus/author', '', TRUE);
			} else if ($role_id == $CI -> Model_role -> MENTOR){
				$menu .= $CI -> load -> view('desktop/user/menus/mentor', '', TRUE);
			} else {
				$menu .= $CI -> load -> view('desktop/user/menus/guest', '', TRUE);
			}
			
			$menu .= $CI->load->view('desktop/user/menus/global', null, TRUE);
		}
		return $CI -> load -> view('desktop/admin_menu', array('menu' => $menu), TRUE);
	}

}
if (!function_exists('check_login')) {
	function check_login() {
		$CI = &get_instance();
		$is_logged_in = $CI -> session -> userdata('is_logged_in');
		
		$back = uri_string();
		// TODO : Prevod
		if (empty($is_logged_in)) {
			redirect('site/login?redirect='.$back);
		}
	}

}

if (!function_exists('is_logged_in')) {
	function is_logged_in() {
		$CI = &get_instance();
		$is = $CI -> session -> userdata('is_logged_in');
		return (!empty($is));
	}

}
function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}
function randInt($length, $charset='123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}
function captcha()
	{
		$this->load->helper('captcha');
		$captcha = array(
		  'word' => $this->randString(6),
    'img_path' => "./materijali/captcha/",
    'img_url' => base_url()."materijali/captcha/",
    'font_path' => "./materijali/captcha_font/".$this->randInt(1)."/captcha.ttf",
    'img_width' => '150',
    'img_height' => 30,
    'expiration' => 720000
		);
		$img = create_captcha($captcha);
		return $img;
		
	}

