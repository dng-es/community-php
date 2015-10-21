<?php
/**
* @Manage rankings
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0.1
* 
*/
class rankingsCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	// public static function userMenu(){
	// 	$array_final = array();
	// 	global $session;
	// 	$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ranking", $_SESSION['user_name']));
	// 	if ($session->checkPageViewPermission("ranking", $_SESSION['user_perfil'], $user_permissions)){
	// 		array_push($array_final, array("LabelIcon" => "fa fa-trophy",
	// 						"LabelItem" => 'Ranking',
	// 						"LabelUrl" => 'ranking',
	// 						"LabelTarget" => '_self',
	// 						"LabelPos" => 8));
	// 	}
	// 	return $array_final;		
	// }	

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-rankings",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Rankings_list"),
				"LabelUrl" => "admin-rankings",
				"LabelPos" => 2,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-ranking",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("New_ranking"),
				"LabelUrl" => "admin-ranking",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-rankings-category",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Nueva categoría"),
				"LabelUrl" => "admin-rankings-category",
				"LabelPos" => 3,
			)),			
			menu::addAdminMenu(array(
				"PageName" => "admin-rankings-categories",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Listado de categorías"),
				"LabelUrl" => "admin-rankings-categories",
				"LabelPos" => 4,
			))
		);
	}
}
?>