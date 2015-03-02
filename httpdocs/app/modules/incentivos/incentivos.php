<?php
/**
* @Manage incentivos
* @author [author] <[email]>
* @version 1.0
*
*/

class incentivosCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
/*	public static function userMenu(){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("incentives", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("incentives", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-money",
							"LabelItem" => strTranslate("Incentives"),
							"LabelUrl" => 'incentives',
							"LabelTarget" => '_self',
							"LabelPos" => 9));
		}
		return $array_final;		
	}*/	

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
				"LabelItem" => strTranslate("Incentives_list"),
				"LabelUrl" => "admin-incentives",
				"LabelPos" => 2,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-fabricantes",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => "Fabricantes",
				"LabelUrl" => "admin-incentives-fabricantes",
				"LabelPos" => 3,
			)),	
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-products",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => "Productos",
				"LabelUrl" => "admin-incentives-products",
				"LabelPos" => 4,
			)),	
			menu::addAdminMenu(array(
				"PageName" => "admin-incentives-products",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incentives"),
				"LabelItem" => "Carga de ventas",
				"LabelUrl" => "admin-cargas-incentives",
				"LabelPos" => 5,
			)),							
		);
	}
}
?>