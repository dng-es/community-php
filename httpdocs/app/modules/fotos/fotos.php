<?php
/**
* @Modulo de fotos, depends on Users module. 
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.2.3

*/
class fotosCore{
	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("galeria_fotos", " AND user_add='".$username."' ");
		$num_votaciones = connection::countReg("galeria_fotos_votaciones", " AND user_votacion='".$username."' ");
		return array(strTranslate("Photo_uploads") => $num,
					strTranslate("Votes_in_photos") => $num_votaciones,);
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-albumes",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Photos"),
			"LabelItem" => strTranslate("Photo_albums"),
			"LabelUrl" => "admin-albumes",
			"LabelPos" => 2,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-validacion-fotos",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Photos"),
			"LabelItem" => strTranslate("Photo_validation"),
			"LabelUrl" => "admin-validacion-fotos",
			"LabelPos" => 3,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-albumes-new",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Photos"),
			"LabelItem" => strTranslate("New_album"),
			"LabelUrl" => "admin-albumes-new",
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
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("foto-albums", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("foto-albums", $_SESSION['user_perfil'], $user_permissions)){
			$module_config = getModuleConfig("fotos");
			$alerts_text = "";
			if ($module_config['options']['show_alarms']):
				$num_alerts = connection::countReg("notifications", " AND username_notification='".$_SESSION['user_name']."' AND type_notification='fotos' ");
				$alerts_text = ($num_alerts > 0 ? ' <span class="menu-alert" title="'.strTranslate("Notifications_comment_new").'" id="contador-fotos-header">'.$num_alerts.'</span>' : "");
			endif;
			array_push($array_final, array(
				"LabelIcon" => "fa fa-camera",
				"LabelItem" => strTranslate("Photos").$alerts_text,
				"LabelUrl" => 'foto-albums',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}

	/**
	 * Elementos para el panel de administración principal (?page=admin)
	 * @return 	array           			Array con datos
	 */
	public static function adminPanels(){
		$num_pending = connection::countReg("galeria_fotos", " AND estado=0 ");
		$num_pending = ($num_pending > 0 ? '<span class="label label-warning">'.$num_pending.'</span>' : $num_pending);
		return array(array("LabelSection" => strTranslate("Photos"),
							"LabelItem" => strTranslate("Photo_albums"),
							"LabelUrlText"=> strTranslate("Go_to"),
							"LabelUrl" => 'admin-albumes',
							"LabelPos" => 1),
					array("LabelSection"=> strTranslate("Photos"),
							"LabelItem"=> strTranslate("Photos_pending"),
							"LabelUrlText"=> $num_pending,
							"LabelUrl"=>'admin-validacion-fotos',
							"LabelPos" => 2));
	}

	public static function searchMain($string){
		$fotos = new fotos();
		$result = array();

		$module_config = getModuleConfig("foro");
		$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal_album LIKE '%".$_SESSION['user_canal']."%' " : "");
		//buscar albumes
		$request = $fotos->getFotosAlbumes($filtro_canal." AND MATCH(nombre_album) AGAINST ('".$string."') AND activo=1 ");
		foreach ($request as $req):
			array_push($result, array(
				"title"=>$req['nombre_album'], 
				"description"=>strTranslate("Photo_albums"), 
				"url"=>"fotos?id=".$req['id_album']."&search=".$string,
				"type" => strTranslate("Photo_gallery"),
				"order" => 11
			));
		endforeach;	

		//buscar fotos
		$request = $fotos->getFotos($filtro_canal." AND MATCH(titulo) AGAINST ('".$string."') AND estado=1 ");
		foreach ($request as $req):
			array_push($result, array(
				"title"=>$req['titulo'], 
				"description"=>strTranslate("Photo_gallery"), 
				"url"=>"fotos?find_reg=".$string,
				"type" => strTranslate("Photo"),
				"order" => 12
			));
		endforeach;	

		if (strtolower($string) == strtolower(strTranslate("Photo")) || strtolower($string) == strtolower(strTranslate("Photos")) || strtolower($string) == strtolower(strTranslate("Photo_gallery"))){
			array_push($result, array(
				"title"=>'<i class="fa fa-list"></i> '.strTranslate("Photo"), 
				"description"=>strTranslate("Photo_gallery"), 
				"url"=>"foto-albums",
				"type" => strTranslate("Photo"),
				"order" => 10
			));
		}

		return $result;
	}	
}
?>