<?php
class usersCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu(){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ranking", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("ranking", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-trophy",
							"LabelItem" => 'Ranking',
							"LabelUrl" => 'ranking',
							"LabelTarget" => '_self',
							"LabelPos" => 8));
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
	}	
}
?>