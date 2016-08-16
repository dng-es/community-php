<?php
/**
* @Manage recompensas
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/

class recompensasCore {
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-recompensa",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rewards"),
				"LabelItem" => strTranslate("New_reward"),
				"LabelUrl" => "admin-recompensa",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-recompensas",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rewards"),
				"LabelItem" => strTranslate("Rewards_list"),
				"LabelUrl" => "admin-recompensas",
				"LabelPos" => 2,
			))
		);
	}
}
?>