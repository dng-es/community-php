<?php
/**
* @Videos module, depends on Users module.
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0.1 
* 
*/
class videosCore{
	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("galeria_videos"," AND user_add='".$username."' ");
		$num_votaciones = connection::countReg("galeria_videos_votaciones"," AND user_votacion='".$username."' ");
		$num_comentarios = connection::countReg("galeria_videos_comentarios"," AND user_comentario='".$username."' ");
		$num_comentarios_votaciones = connection::countReg("galeria_videos_comentarios_votaciones"," AND user_votacion='".$username."' ");
		return array( strTranslate("Video_uploads") => $num,
				strTranslate("Votes_in_videos") => $num_votaciones,
				strTranslate("Comments_in_videos") => $num_comentarios,
				strTranslate("Votes_in_videos_comments") => $num_comentarios_votaciones);
	}

	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-videos",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Videos"),
				"LabelItem" => strTranslate("Video_list"),
				"LabelUrl" => "admin-videos",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-validacion-videos",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("Videos"),
				"LabelItem" => strTranslate("Video_validation"),
				"LabelUrl" => "admin-validacion-videos",
				"LabelPos" => 2,
			))
		);
	}

	public static function userMenu($menu_order){
		$array_final = array();
		global $session;
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("video", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("video", $_SESSION['user_perfil'], $user_permissions)){

			array_push($array_final, array("LabelIcon" => "fa fa-video-camera",
						"LabelItem" => strTranslate("Videos"),
						"LabelUrl" => 'videos',
						"LabelTarget" => '_self',
						"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	public static function adminPanels(){
		$num_pending = connection::countReg("galeria_videos"," AND estado=0 ");
		$num_pending = ($num_pending > 0 ? '<span class="label label-warning">'.$num_pending.'</span>' : $num_pending);
		return array( array("LabelSection"=> strTranslate("Videos"),
							"LabelItem"=> strTranslate("Videos_pending"),
							"LabelUrlText"=> $num_pending,
							"LabelUrl"=>'admin-validacion-videos',
							"LabelPos" => 2),
					array("LabelSection"=> strTranslate("Videos"),
							"LabelItem"=> strTranslate("Video_list"),
							"LabelUrlText"=> strTranslate("Go_to"),
							"LabelUrl"=>'admin-videos',
							"LabelPos" => 1));
	}
}
?>