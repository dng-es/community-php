<?php
/**
* @Manage batallas
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/

class batallasCore {
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu($menu_order){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("batallas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("batallas", $_SESSION['user_perfil'], $user_permissions)){
			//batallas pendientes
			$filtro_batallas =  " AND finalizada=0 AND user_retado='".$_SESSION['user_name']."' AND id_batalla NOT IN ( SELECT id_batalla FROM batallas_luchas WHERE user_lucha='".$_SESSION['user_name']."' ) ";
			$pendientes_batallas = connection::countReg("batallas",$filtro_batallas);
			$label_batallas = ($pendientes_batallas==0 ? '' : ' <span class="menu-alert">'.$pendientes_batallas.'</span>');

			array_push($array_final, array("LabelIcon" => "fa fa-bomb",
							"LabelItem" => strTranslate("Battles").$label_batallas,
							"LabelUrl" => 'batallas',
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
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-batallas",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Battles"),
			"LabelItem" => strTranslate("Battles_list"),
			"LabelUrl" => "admin-batallas",
			"LabelPos" => 1,
		)));

		return $elems;
	}
}
?>