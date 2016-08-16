<?php
/**
* @Libreria de archivos descargables para el usuario
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1.1
*
*/
class infotopdfCore{
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-infotopdf-all", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-infotopdf-all", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-file-pdf-o",
							"LabelItem" => strTranslate("Infotopdf_Documents"),
							"LabelUrl" => 'user-infotopdf-all',
							"LabelTarget" => '_self',
							"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	public static function adminMenu(){
		return array( 
			menu::addAdminMenu(array(
				"PageName" => "admin-infotopdf-doc",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Infotopdf_Documents"),
				"LabelItem" => "Nuevo documento",
				"LabelUrl" => "admin-infotopdf-doc?act=new",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-infotopdf",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Infotopdf_Documents"),
				"LabelItem" => "Listado de documentos",
				"LabelUrl" => "admin-infotopdf",
				"LabelPos" => 2,
			))
		);
	}
}
?>