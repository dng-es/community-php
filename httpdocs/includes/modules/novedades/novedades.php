<?php
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