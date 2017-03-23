<?php
/**
* @Modulo de notificaciones
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.1
* 
*/
class notificationsCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	// public static function userMenu($menu_order){
	// 	global $session;
	// 	$array_final = array();
	// 	$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ranking", $_SESSION['user_name']));
	// 	if ($session->checkPageViewPermission("ranking", $_SESSION['user_perfil'], $user_permissions)){
	// 		array_push($array_final, array("LabelIcon" => "fa fa-trophy",
	// 						"LabelItem" => 'Ranking',
	// 						"LabelUrl" => 'ranking',
	// 						"LabelTarget" => '_self',
	// 						"LabelPos" => $menu_order));
	// 	}
	// 	return $array_final;
	// }

	// /**
	//  * Elementos para el menu de administración
	//  * @return 	array           			Array con datos
	//  */	
	// public static function adminMenu(){
	// 	return array(
	// 		menu::addAdminMenu(array(
	// 			"PageName" => "admin-users",
	// 			"LabelHeader" => "Tools",
	// 			"LabelSection" => strTranslate("Users"),
	// 			"LabelItem" => strTranslate("Users_list"),
	// 			"LabelUrl" => "admin-users",
	// 			"LabelPos" => 1,
	// 		))
	// 	);
	// }
}
?>