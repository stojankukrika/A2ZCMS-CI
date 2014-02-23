<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
Author: Stojan Kukrika
Version: 1.0
*/

// ------------------------------------------------------------------------
class Model_menu extends CI_Model{
	
	function pagesmenu($type){
		$menu = $this->main_menu($type);
		return $menu;
	}
	
	public function main_menu($type) {
		$navigation ="";
		switch ($type) {
			case 'top':
				$navigation = $this->db->from('navigation_groups')
										-> join('navigation_links','navigation_groups.id = navigation_links.navigation_group_id' )
										-> where('navigation_groups.showmenu','1') 
										-> select('navigation_links.id,navigation_links.title,navigation_links.parent,navigation_links.page_id,navigation_links.link_type,navigation_links.url,navigation_links.uri,navigation_links.link_type,navigation_links.target,navigation_links.position,navigation_links.class') 
										-> get()->result_array();
				break;
			case 'footer':
				$navigation = $this->db->from('navigation_groups')
										-> join('navigation_links','navigation_groups.id = navigation_links.navigation_group_id' )
										-> where('navigation_groups.showfooter','1') 
										-> select('navigation_links.id,navigation_links.title,navigation_links.parent,navigation_links.page_id,navigation_links.link_type,navigation_links.url,navigation_links.uri,navigation_links.link_type,navigation_links.target,navigation_links.position,navigation_links.class') 
										-> get()->result_array();
				break;
			case 'side':
			$navigation = $this->db->from('navigation_groups')
										-> join('navigation_links','navigation_groups.id = navigation_links.navigation_group_id' )
										-> where('navigation_groups.showsidebar','1') 
										-> select('navigation_links.id,navigation_links.title,navigation_links.parent,navigation_links.page_id,navigation_links.link_type,navigation_links.url,navigation_links.uri,navigation_links.link_type,navigation_links.target,navigation_links.position,navigation_links.class') 
										-> get()->result_array();
				break;
		}		
		
		$menu = array('items' => array(), 'parents' => array());
		// Builds the array lists with data from the menu table
		foreach ($navigation as $items) {
			// Creates entry into items array with current menu item id ie. $menu['items'][1]
			$menu['items'][$items['id']] = $items;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$items['parent'] = (is_null($items['parent'])) ? 0 : $items['parent'];
			$menu['parents'][$items['parent']][] = $items['id'];
		}
		return $this -> buildMenu(0, $menu);
	}

	// Menu builder function, parentId 0 is the root
	public function buildMenu($parent, $menu) {
		$html = '';
		if (isset($menu['parents'][$parent])) {
			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {

					$html .= "<li> <a target='".$menu['items'][$itemId]['target']."' class='".$menu['items'][$itemId]['class']."' href='";
					switch ($menu['items'][$itemId]['link_type']) {
						case 'page':
							$html .= base_url('pages') ."/". $menu['items'][$itemId]['id'];
							break;
						case 'url':
							$html .= base_url($menu['items'][$itemId]['uri']);
							break;
						case 'uri':
							$html .=$menu['items'][$itemId]['url'];
							break;
					}
					$html .="'>" . $menu['items'][$itemId]['title'] . "</a></li>";
				}
				if (isset($menu['parents'][$itemId])) {
					$html .= "<li class='dropdown'> <a target='".$menu['items'][$itemId]['target']."' class='dropdown-toggle ".$menu['items'][$itemId]['class']."' href='";
					switch ($menu['items'][$itemId]['link_type']) {
						case 'page':
							$html .= base_url('pages') ."/". $menu['items'][$itemId]['id'];
							break;
						case 'url':
							$html .= base_url($menu['items'][$itemId]['uri']);
							break;
						case 'uri':
							$html .=$menu['items'][$itemId]['url'];
							break;
					}
					$html .="'>" . $menu['items'][$itemId]['title'] . "</a>
						<ul class='dropdown-menu'>";
					$html .= $this -> buildMenu($itemId, $menu);
					$html .= " </ul></li>";
				}
			}
		}
		return $html;
	}
	
	function menu_admin(){
		//Just a prototype

		$menu = new stdClass();
		$menu->url = "admin/pages/index";
		$menu->name = "Admin";

		return $menu;
	}
	
	
		
}

?>