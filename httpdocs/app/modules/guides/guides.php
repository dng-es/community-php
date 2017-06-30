<?php
/**
* @Manage guides
* @author [author] <[email]>
* @version 1.0
*
*/
class guidesCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array		Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("guides", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("guides", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-file",
							"LabelItem" => strTranslate("Guides"),
							"LabelUrl" => 'guides',
							"LabelTarget" => '_self',
							"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-guides",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Guides"),
			"LabelItem" => strTranslate("Guides_list"),
			"LabelUrl" => "admin-guides",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-guides-categories",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Guides"),
			"LabelItem" => strTranslate("Guides_categories"),
			"LabelUrl" => "admin-guides-categories",
			"LabelPos" => 2,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-guides-subcategories",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Guides"),
			"LabelItem" => strTranslate("Guides_subcategories"),
			"LabelUrl" => "admin-guides-subcategories",
			"LabelPos" => 3,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-guides-subcategories-types",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Guides"),
			"LabelItem" => strTranslate("Guides_subcategories_types"),
			"LabelUrl" => "admin-guides-subcategory-types",
			"LabelPos" => 4,
		)));	

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-guides-subcategories-users",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Guides"),
			"LabelItem" => strTranslate("Guides_subcategories_users"),
			"LabelUrl" => "admin-guides-subcategory-users",
			"LabelPos" => 5,
		)));	

		return $elems;
	}
}
?>