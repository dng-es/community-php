<?php
class pagesCore{
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-page",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Pages"),
				"LabelItem" => strTranslate("New_page"),
				"LabelUrl" => "admin-page",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-pages",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Pages"),
				"LabelItem" => strTranslate("Pages_list"),
				"LabelUrl" => "admin-pages",
				"LabelPos" => 2,
			))
		);
	}		
}
?>