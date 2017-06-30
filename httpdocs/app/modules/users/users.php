<?php
/**
* @Modulo de usuarios
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.3
* 
*/
class usersCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ranking", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("ranking", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-trophy",
				"LabelItem" => 'Ranking',
				"LabelUrl" => 'ranking',
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
		$menu_elems = array(
			menu::addAdminMenu(array(
				"PageName" => "admin-users",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Users_list"),
				"LabelUrl" => "admin-users",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-cargas-users",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Users_import"),
				"LabelUrl" => "admin-cargas-users",
				"LabelPos" => 2,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-puntos",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Points_assignment"),
				"LabelUrl" => "admin-puntos",
				"LabelPos" => 3,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-users-tiendas",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Users_groups_list"),
				"LabelUrl" => "admin-users-tiendas",
				"LabelPos" => 4,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-cargas-tiendas",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Groups_import"),
				"LabelUrl" => "admin-cargas-tiendas",
				"LabelPos" => 5,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-canales",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Channel_list"),
				"LabelUrl" => "admin-canales",
				"LabelPos" => 6,
			)),
/*			menu::addAdminMenu(array(
				"PageName" => "admin-canal",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Users"),
				"LabelItem" => strTranslate("Channel_new"),
				"LabelUrl" => "admin-canal",
				"LabelPos" => 7,
			)),	*/
			menu::addAdminMenu(array(
				"PageName" => "admin-informe-puntuaciones",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Reports"),
				"LabelItem" => ucfirst(strTranslate("APP_points")),
				"LabelUrl" => "admin-informe-puntuaciones",
				"LabelPos" => 2,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-informe-participaciones",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Reports"),
				"LabelItem" => ucfirst(strTranslate("APP_shares")),
				"LabelUrl" => "admin-informe-participaciones",
				"LabelPos" => 3,
			))
		);

		if(getModuleExist("shop") || getModuleExist("prestashop")){
			array_push($menu_elems, 
				menu::addAdminMenu(array(
					"PageName" => "admin-creditos",
					"LabelHeader" => "Tools",
					"LabelSection" => strTranslate("Users"),
					"LabelItem" => "Asignacion de ".strTranslate("APP_Credits"),
					"LabelUrl" => "admin-creditos",
					"LabelPos" => 4,
				)));

			array_push($menu_elems, 
				menu::addAdminMenu(array(
					"PageName" => "admin-informe-creditos",
					"LabelHeader" => "Tools",
					"LabelSection" => strTranslate("Reports"),
					"LabelItem" => ucfirst(strTranslate("APP_Credits")),
					"LabelUrl" => "admin-informe-creditos",
					"LabelPos" => 3,
				)));
		}

		return $menu_elems;
	}
}
?>