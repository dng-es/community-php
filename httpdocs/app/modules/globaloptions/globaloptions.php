<?php
/**
* @Manage globaloptions
* @author [author] <[email]>
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
						"LabelUrl" => 'https://www.myglobaloptions.com',
						"LabelTarget" => '_blank',
						"LabelPos" => 10));

		return $array_final;		
	}	
}
?>