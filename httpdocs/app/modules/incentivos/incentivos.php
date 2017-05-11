<?php
/**
* @Manage incentivos
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.1.3
*
*/

class incentivosCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("incentives-targets", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("incentives-targets", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-trophy",
				"LabelItem" => strTranslate("Incentives"),
				"LabelUrl" => 'incentives-targets',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => strTranslate("Incentives_targets"),
				"LabelUrl" => "admin-incentives-targets",
				"LabelPos" => 4,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-fabricantes",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => strTranslate("Incentives_manufacturers"),
				"LabelUrl" => "admin-incentives-fabricantes",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-products",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => strTranslate("Incentives_products"),
				"LabelUrl" => "admin-incentives-products",
				"LabelPos" => 2,
			)),	
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-products",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => strTranslate("Incentives_sales"),
				"LabelUrl" => "admin-incentives-ventas",
				"LabelPos" => 3,
			)),
		);
	}
}
?>