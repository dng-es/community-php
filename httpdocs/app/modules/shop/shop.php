<?php
/**
* @Manage shop
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.3.3
*
*/

class shopCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("shopproducts", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("shopproducts", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-shopping-cart",
				"LabelItem" => strTranslate("APP_Shop"),
				"LabelUrl" => 'shopproducts',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}
	
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-shopproducts",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("APP_Shop"),
				"LabelItem" => strTranslate("Shop_products_list"),
				"LabelUrl" => "admin-shopproducts",
				"LabelPos" => 2,
			)), 
			menu::addAdminMenu(array(
				"PageName" => "admin-shopproducts",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("APP_Shop"),
				"LabelItem" => strTranslate("Shop_manufacturers_list"),
				"LabelUrl" => "admin-shopmanufacturers",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-shoporders",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("APP_Shop"),
				"LabelItem" => strTranslate("Shop_orders_list"),
				"LabelUrl" => "admin-shoporders",
				"LabelPos" => 2,
			))
		);
	}
}
?>