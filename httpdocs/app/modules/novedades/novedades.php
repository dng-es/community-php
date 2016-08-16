<?php
/**
* @Modulo Novedades
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1
*
*/
class novedadesCore{
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-novedad",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("News"),
				"LabelItem" => strTranslate("News_new"),
				"LabelUrl" => "admin-novedad",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-novedades",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("News"),
				"LabelItem" => strTranslate("News_list"),
				"LabelUrl" => "admin-novedades",
				"LabelPos" => 2,
			))
		);
	}
}
?>