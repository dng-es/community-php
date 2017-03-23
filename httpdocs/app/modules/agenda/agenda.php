<?php
/**
* @Manage agenda. Depende del módulo de foros
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.1
*
*/
class agendaCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array					Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("agenda", $_SESSION['user_name']));

		if ($session->checkPageViewPermission("agenda", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-bullhorn",
				"LabelItem" => strTranslate("Diary"),
				"LabelUrl" => 'agenda',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}

		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ofertas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("ofertas", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-star",
				"LabelItem" => strTranslate("Offers"),
				"LabelUrl" => 'ofertas',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array				Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-agenda-new",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Diary_and_offers"),
				"LabelItem" => strTranslate("New_diary_and_offers"),
				"LabelUrl" => "admin-agenda-new",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-agenda",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Diary_and_offers"),
				"LabelItem" => "Listado de agenda/oferta",
				"LabelUrl" => "admin-agenda",
				"LabelPos" => 2,
			))
		);
	}
}
?>