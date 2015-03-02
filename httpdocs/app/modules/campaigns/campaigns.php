<?php

class campaignsCore{
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-campaign",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Campaigns"),
			"LabelItem" => strTranslate("New_campaign"),
			"LabelUrl" => "admin-campaign?act=new",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-campaigns",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Campaigns"),
			"LabelItem" => strTranslate("Campaigns_list"),
			"LabelUrl" => "admin-campaigns",
			"LabelPos" => 2,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-campaigns-types",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Campaigns"),
			"LabelItem" => strTranslate("Campaign_types"),
			"LabelUrl" => "admin-campaigns-types",
			"LabelPos" => 3,
		)));	

		return $elems;
	}
}
?>