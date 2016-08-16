<?php
/**
* @Manage incentivos
* @author David Noguera <dnoguera@imagar.com>
* @version 1.0
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

		$array_final_items = array();

		//menu ver todas las comunicaciones	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-templates", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-templates", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => strTranslate("Incentives_my_sales"),
							"LabelUrl" => 'incentives-ventas',
							"LabelTarget" => '_self'));
		}

		//menu ver todas las comunicaciones	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-lists", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-lists", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => strTranslate("Incentives_my_targets"),
							"LabelUrl" => 'incentives-targets',
							"LabelTarget" => '_self'));
		}

		//menu ver todas las comunicaciones	
/*		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-messages", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-messages", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => "Rankings",
							"LabelUrl" => 'incentives-rankings',
							"LabelTarget" => '_self'));
		}*/

		if (count($array_final_items)>0){
				array_push($array_final, array("LabelIcon" => "fa fa-gift",
								"LabelItem" => strTranslate("Incentives"),
								"LabelUrl" => '',
								"LabelTarget" => '',
								"SubItems" => $array_final_items,
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