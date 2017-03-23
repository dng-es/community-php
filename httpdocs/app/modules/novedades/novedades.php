<?php
/**
* @Modulo Novedades
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.2.1
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