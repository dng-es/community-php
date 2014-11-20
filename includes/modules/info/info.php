<?php
class infoCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu(){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-info-all", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-info-all", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-file",
							"LabelItem" => strTranslate("Info_Documents"),
							"LabelUrl" => '?page=user-info-all',
							"LabelTarget" => '_self',
							"LabelPos" => 7));
		}
		return $array_final;		
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-info-doc",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Info_Documents"),
			"LabelItem" => strTranslate("Info_Documents_new"),
			"LabelUrl" => "admin-info-doc&act=new",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-info",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Info_Documents"),
			"LabelItem" => strTranslate("Info_Documents_list"),
			"LabelUrl" => "admin-info",
			"LabelPos" => 2,
		)));

		return $elems;	
	}
}
?>