<?php
/**
* @Manage globaloptions
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/

class globaloptionsCore {
		/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu(){
		$array_final = array();
		global $session;


		array_push($array_final, array("LabelIcon" => "fa fa-comment",
						"LabelItem" => "Tienda",
						"LabelUrl" => 'home?gogo=1',
						"LabelTarget" => '_blank',
						"LabelPos" => 10));

		return $array_final;		
	}	
}
?>