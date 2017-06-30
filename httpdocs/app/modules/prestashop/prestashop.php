<?php
/**
* @Manage shop
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/

class prestashopCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("shopproducts", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("ps-products", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-shopping-cart",
				"LabelItem" => strTranslate("APP_Prestashop"),
				"LabelUrl" => 'ps-products',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}
}
?>