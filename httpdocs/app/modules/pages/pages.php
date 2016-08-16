<?php
/**
* @Modulo de gestión de páginas de la app
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.3
*
*/
class pagesCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu(){
		global $session;
		$array_final = array();

		//Obtenciópn de las páginas por menu
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND (page_canal='".$_SESSION['user_canal']."' OR page_canal='') " : "");
		$pages_menu = pagesController::getListAction(999, $filtro_canal." AND page_user_menu=1 ");

		if ($pages_menu['total_reg']>0):
			$array_final_items = array();
			foreach ($pages_menu['items'] as $page_menu):	
				array_push($array_final, array("LabelIcon" => "fa fa-th-list",
							"LabelItem" => $page_menu['page_title'],
							"LabelUrl" => 'pagename?id='.$page_menu['page_name'],
							"LabelTarget" => '_self',
							"LabelPos" => $page_menu['page_user_menu_order']));
			endforeach;
		endif;

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-page",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Pages"),
				"LabelItem" => strTranslate("New_page"),
				"LabelUrl" => "admin-page",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-pages",
				"LabelHeader" => "Tools",
				"LabelSection" => strTranslate("Pages"),
				"LabelItem" => strTranslate("Pages_list"),
				"LabelUrl" => "admin-pages",
				"LabelPos" => 2,
			))
		);
	}
}
?>