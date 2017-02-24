<?php
/**
* @Manage incidencias
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/

class incidenciasCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();

		array_push($array_final, array("LabelIcon" => "fa fa-life-ring",
				"LabelItem" => strTranslate("My_incidences"),
				"LabelUrl" => 'myincidences',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-incidences",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Incidences"),
				"LabelItem" => strTranslate("Incidences_list"),
				"LabelUrl" => "admin-incidences",
				"LabelPos" => 2,
			))
		);
	}	
}
?>