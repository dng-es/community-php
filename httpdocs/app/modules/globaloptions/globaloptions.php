<?php
/**
* @Manage globaloptions
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/

class globaloptionsCore {
		/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu($menu_order){
		$array_final = array();
		global $session;
		array_push($array_final, array(
			"LabelIcon" => "fa fa-comment",
			"LabelItem" => "Global options",
			"LabelId" => "tienda_go",
			"LabelUrl" => 'home?gogo=1',
			"LabelTarget" => '_blank',
			"LabelPos" => $menu_order));

		return $array_final;		
	}	
}
?>