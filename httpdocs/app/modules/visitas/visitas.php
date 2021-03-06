<?php
/**
* @Control de accesos e informes estadísticos
* @author Imagar Informatica SL
* @version 1.2
* 
*/
class visitasCore{
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-informe-accesos",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Reports"),
				"LabelItem" => strTranslate("Visits_title"),
				"LabelUrl" => "admin-informe-accesos",
				"LabelPos" => 1,
			))
		);
	}
}
?>