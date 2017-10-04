<?php
/**
* @Manage blog. Depende del módulo de foros
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.2
*
*/
class blogCore{
	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("foro_comentarios c LEFT JOIN foro_temas t ON c.id_tema=t.id_tema ", " AND t.ocio=1 AND c.user_comentario='".$username."' ");
		return array(strTranslate("Comments_in_blogs") => $num);
	}

	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("blog", $_SESSION['user_name']));
		if($session->checkPageViewPermission("blog", $_SESSION['user_perfil'], $user_permissions)){
			$module_config = getModuleConfig("blog");
			$alerts_text = "";
			if ($module_config['options']['show_alarms']):
				$num_alerts = blogController::getAlerts();
				$alerts_text = ($num_alerts > 0 ? ' <span class="menu-alert" title="'.strTranslate("Notifications_content_new").'" id="contador-blog-header">'.$num_alerts.'</span>' : "");
			endif;
			array_push($array_final, array(
				"LabelIcon" => "fa fa-globe",
				"LabelItem" => strTranslate("Blog").$alerts_text,
				"LabelUrl" => 'blog',
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

	public static function searchMain($string){
		$result = array();
		$foro = new foro();
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal LIKE '%".$_SESSION['user_canal']."%' " : "");
		//buscar temas
		$request = $foro->getTemas($filtro_canal." AND (MATCH(nombre) AGAINST ('".$string."') OR MATCH(descripcion) AGAINST ('".$string."')) AND ocio=1 AND activo=1 AND id_area=0 ");
		foreach ($request as $req):
			array_push($result, array(
				"title"=>$req['nombre'], 
				"description"=>$req['descripcion'], 
				"url"=>"blog?id=".$req['id_tema'],
				"type" => strTranslate("Blog"),
				"order" => 9
			));
		endforeach;	

		if (strtolower($string) == strtolower(strTranslate("Blog"))){
			array_push($result, array(
				"title"=>'<i class="fa fa-list"></i> '.strTranslate("Blog"), 
				"description"=>strTranslate("Last_blog"), 
				"url"=>"blog",
				"type" => strTranslate("Blog"),
				"order" => 8
			));
		}

		return $result;
	}	
}
?>