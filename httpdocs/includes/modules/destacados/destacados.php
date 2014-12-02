<?php
class destacadosCore{
		/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-destacados",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Highlights"),
			"LabelItem" => strTranslate("Edit")." ".strTranslate("Highlights"),
			"LabelUrl" => "admin-destacados",
			"LabelPos" => 1,
		)));
		
		return $elems;	
	}
}
?>