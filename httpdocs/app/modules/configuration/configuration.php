<?php
/**
* @Configuration app module
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.2.2
*/	
class configurationCore{
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-config",
			"LabelHeader" => "Tools",
			"LabelSection" => strTranslate("Configuration"),
			"LabelItem" => strTranslate("Main_data"),
			"LabelUrl" => "admin-config",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-modules",
			"LabelHeader" => "Tools",
			"LabelSection" => strTranslate("Configuration"),
			"LabelItem" => strTranslate("Modules_settings"),
			"LabelUrl" => "admin-modules",
			"LabelPos" => 2,
		)));

		return $elems;
	}
}
?>