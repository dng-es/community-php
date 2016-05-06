<?php
/**
* @Manage rankings
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0.1
* 
*/
class rankingsCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu(){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("ranking", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("ranking", $_SESSION['user_perfil'], $user_permissions)){
			//OBTENCION DE RANKINGS ACTIVOS
			$rankings_cat_menu = rankingsController::getListCategoryAction(999, " ");

			if ($rankings_cat_menu['total_reg']>0):
				$i = 2;
				foreach ($rankings_cat_menu['items'] as $ranking_cat):	
					
					$rankings_menu = rankingsController::getListAction(999, " AND activo=1 AND r.id_ranking_category=".$ranking_cat['id_ranking_category']." ");
					if ($rankings_menu['total_reg']>0):
						$array_final_items = array();
						foreach ($rankings_menu['items'] as $ranking):	
							array_push($array_final_items , array("LabelIcon" => "",
											"LabelItem" => $ranking['nombre_ranking'],
											"LabelUrl" => 'rankings?id='.$ranking['id_ranking'],
											"LabelTarget" => '_self'));
						endforeach;

						array_push($array_final, array("LabelIcon" => "fa fa-th-list",
										"LabelItem" => $ranking_cat['ranking_category_name'],
										"LabelUrl" => '',
										"LabelTarget" => '',
										"SubItems" => $array_final_items,
										"LabelPos" => $i));

						$i++;
					endif;
				endforeach;
			endif;

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
				"PageName" => "admin-rankings",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Rankings_list"),
				"LabelUrl" => "admin-rankings",
				"LabelPos" => 2,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-ranking",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("New_ranking"),
				"LabelUrl" => "admin-ranking",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-rankings-category",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Nueva categoría"),
				"LabelUrl" => "admin-rankings-category",
				"LabelPos" => 3,
			)),			
			menu::addAdminMenu(array(
				"PageName" => "admin-rankings-categories",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Rankings"),
				"LabelItem" => strTranslate("Listado de categorías"),
				"LabelUrl" => "admin-rankings-categories",
				"LabelPos" => 4,
			))
		);
	}
}
?>