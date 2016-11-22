<?php
/**
* @Manage promociones
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/

class promocionesCore {
/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	// public static function userMenu($menu_order){
	// 	global $session;
	// 	$array_final = array();
	// 	$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("reto", $_SESSION['user_name']));

	// 	$id_promocion = connection::SelectMaxReg("id_promocion", "promociones", " AND active=1 ");

	// 	if ($session->checkPageViewPermission("reto", $_SESSION['user_perfil'], $user_permissions)){
	// 		array_push($array_final, array("LabelIcon" => "fa fa-globe",
	// 						"LabelItem" => "Reto",
	// 						"LabelUrl" => 'reto?idp='.$id_promocion,
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
	// 			"PageName" => "admin-promociones-new",
	// 			"LabelHeader" => "Modules",
	// 			"LabelSection" => "Reto",
	// 			"LabelItem" => "Nuevo reto",
	// 			"LabelUrl" => "admin-promociones-new",
	// 			"LabelPos" => 1,
	// 		)),
	// 		menu::addAdminMenu(array(
	// 			"PageName" => "admin-promociones",
	// 			"LabelHeader" => "Modules",
	// 			"LabelSection" => "Reto",
	// 			"LabelItem" => "Listado de retos",
	// 			"LabelUrl" => "admin-promociones",
	// 			"LabelPos" => 2,
	// 		))
	// 	);
	// }
}
?>