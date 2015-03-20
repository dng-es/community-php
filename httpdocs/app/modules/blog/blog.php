<?php

class blogCore{
	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("foro_comentarios c LEFT JOIN foro_temas t ON c.id_tema=t.id_tema "," AND t.ocio=1 AND c.user_comentario='".$username."' ");


		return array('Comentarios en los blogs' => $num);	
	}	

	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
	public static function userMenu(){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("blog", $_SESSION['user_name']));
		
		$module_config = getModuleConfig("blog");
		$alerts_text = "";
		if ($module_config['options']['show_alarms']):
			$num_alerts = blogController::getAlerts();
			$alerts_text = ($num_alerts>0 ? ' <span class="menu-alert" id="contador-blog-header">'.$num_alerts.'</span>' : "");
		endif;

		if ($session->checkPageViewPermission("blog", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-globe",
							"LabelItem" => strTranslate("Blog").$alerts_text,
							"LabelUrl" => 'blog',
							"LabelTarget" => '_self',
							"LabelPos" => 2));
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
				"PageName" => "admin-blog-new",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Blog"),
				"LabelItem" => strTranslate("New_post"),
				"LabelUrl" => "admin-blog-new",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-blog",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Blog"),
				"LabelItem" => strTranslate("Posts_list"),
				"LabelUrl" => "admin-blog",
				"LabelPos" => 2,
			))
		);
	}
}
?>