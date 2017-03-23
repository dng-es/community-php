<?php
/**
* @Manage cuestionarios
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.0
*
*/
class cuestionariosCore{
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-cuestionarios",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Forms"),
			"LabelItem" => strTranslate("Forms_list"),
			"LabelUrl" => "admin-cuestionarios",
			"LabelPos" => 2,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-cuestionario",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Forms"),
			"LabelItem" => strTranslate("New_form"),
			"LabelUrl" => "admin-cuestionario",
			"LabelPos" => 1,
		)));

		return $elems;
	}

	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("cuestionario", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("cuestionario", $_SESSION['user_perfil'], $user_permissions)){
			//OBTENCION DE CUESTIONARIOS ACTIVOS
			$cuestionarios_menu = cuestionariosController::getListAction(999, " AND activo=1 ");

			if ($cuestionarios_menu['total_reg']>0):
				$array_final_items = array();
				foreach ($cuestionarios_menu['items'] as $cuestionario):
					array_push($array_final_items , array(
						"LabelIcon" => "",
						"LabelItem" => $cuestionario['nombre'],
						"LabelUrl" => 'cuestionario?id='.$cuestionario['id_cuestionario'],
						"LabelTarget" => '_self'));
				endforeach;

				array_push($array_final, array(
					"LabelIcon" => "fa fa-th-list",
					"LabelItem" => strTranslate("Forms"),
					"LabelUrl" => '',
					"LabelTarget" => '',
					"SubItems" => $array_final_items,
					"LabelPos" => $menu_order));
			endif;

		}

		return $array_final;
	}
}
?>