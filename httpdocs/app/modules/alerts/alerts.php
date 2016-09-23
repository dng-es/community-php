<?php
/**
* @Manage alerts
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 0.9
*
*/

class alertsCore {
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-alerts",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("MOD_Alerts"),
				"LabelItem" => strTranslate("MOD_Alerts_list"),
				"LabelUrl" => "admin-alerts",
				"LabelPos" => 2,
			))
		);
	}
}
?>