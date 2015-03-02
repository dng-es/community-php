<?php
class mailingCore{
/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("mailing_messages"," AND username_add='".$username."' ");
		return array(strTranslate('Massive_Mailing') => $num);
	}

	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */	
/*	public static function userMenu(){
		$array_final = array();
		global $session;
		$array_final_items = array();

		//menu ver todas las comunicaciones	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-templates", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-templates", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => "Ver todas las comunicaciones",
							"LabelUrl" => 'user-templates',
							"LabelTarget" => '_self'));
		}

		//menu ver todas las comunicaciones	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-lists", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-lists", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => strTranslate("Mailing_lists"),
							"LabelUrl" => 'user-lists',
							"LabelTarget" => '_self'));
		}

		//menu ver todas las comunicaciones	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("user-messages", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("user-messages", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final_items , array("LabelIcon" => "",
							"LabelItem" => "Mis comunicaciones enviadas",
							"LabelUrl" => 'user-messages',
							"LabelTarget" => '_self'));
		}


		if (count($array_final_items)>0){
				array_push($array_final, array("LabelIcon" => "fa fa-envelope-o",
								"LabelItem" => strTranslate("Massive_Mailing"),
								"LabelUrl" => '',
								"LabelTarget" => '',
								"SubItems" => $array_final_items,
								"LabelPos" => 2));
		}


		return $array_final;		
	}*/		

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-messages",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Massive_Mailing"),
				"LabelItem" => "Comunicaciones enviadas",
				"LabelUrl" => "admin-messages",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-templates",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Massive_Mailing"),
				"LabelItem" => "Plantillas de comunicaciones",
				"LabelUrl" => "admin-templates",
				"LabelPos" => 2,
			))
		);
	}	
}
?>