<?php
/**
* @Modulo áreas de trabajo. Tareas de formación
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1.1
*
*/
class na_areasCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu(){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("areas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("areas", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-bookmark",
							"LabelItem" => strTranslate("Na_areas"),
							"LabelUrl" => 'areas',
							"LabelTarget" => '_self',
							"LabelPos" => 6));
		}
		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-area",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Na_areas"),
				"LabelItem" => strTranslate("Na_areas_new"),
				"LabelUrl" => "admin-area?act=new",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-areas",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Na_areas"),
				"LabelItem" => strTranslate("Na_areas_list"),
				"LabelUrl" => "admin-areas",
				"LabelPos" => 2,
			))
		);
	}
}
?>