<?php
/**
* @Configuration app module
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1.1
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