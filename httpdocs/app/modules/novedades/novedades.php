<?php
/**
* @Modulo Novedades
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/	
class novedadesCore{
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-novedades",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("News"),
				"LabelItem" => strTranslate("News_update"),
				"LabelUrl" => "admin-novedades",
				"LabelPos" => 1,
			))
		);
	}	
}
?>