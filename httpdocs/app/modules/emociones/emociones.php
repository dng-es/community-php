<?php
/**
* @Modulo de emociones
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version  1.0.2
*
*/
class emocionesCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("foro-subtemas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("foro-subtemas", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-comment",
							"LabelItem" => strTranslate("Emotions"),
							"LabelUrl" => 'emociones',
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
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-emociones",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Emotions"),
			"LabelItem" => strTranslate("Emotions_list"),
			"LabelUrl" => "admin-emociones",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-emociones-users",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Emotions"),
			"LabelItem" => "Emociones de los usuarios",
			"LabelUrl" => "admin-emociones-users",
			"LabelPos" => 2,
		)));

		return $elems;
	}
}
?>