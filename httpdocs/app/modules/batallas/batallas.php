<?php
/**
* @Manage batallas
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.2
*
*/
class batallasCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array					Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("batallas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("batallas", $_SESSION['user_perfil'], $user_permissions)){
			$module_config = getModuleConfig("batallas");
			$alerts_text = "";

			//eliminar batallas caducadas
			batallasController::deleteBatallasCaducadasAction($module_config['options']['battle_days_expiration']);

			if ($module_config['options']['show_alarms']):
				$batallas_pendientes = batallasController::getPendientes($_SESSION['user_name']);
				$alerts_text = ($batallas_pendientes == 0 ? '' : ' <span class="menu-alert">'.$batallas_pendientes.'</span>');
			endif;

			array_push($array_final, array(
				"LabelIcon" => "fa fa-bomb",
				"LabelItem" => strTranslate("Battles").$alerts_text,
				"LabelUrl" => 'batallas',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array					Array con datos
	 */	
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-batallas",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Battles"),
			"LabelItem" => strTranslate("Battles_list"),
			"LabelUrl" => "admin-batallas",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-batallas-preguntas",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Battles"),
			"LabelItem" => strTranslate("Battles_questions_list"),
			"LabelUrl" => "admin-batallas-preguntas",
			"LabelPos" => 2,
		)));

		return $elems;
	}
}
?>