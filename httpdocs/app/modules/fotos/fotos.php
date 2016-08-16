<?php
/**
* @Modulo de fotos, depends on Users module. 
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
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
		return array( strTranslate("Photo_uploads") => $num,
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
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("fotos", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("fotos", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-camera",
							"LabelItem" => strTranslate("Photos"),
							"LabelUrl" => 'fotos',
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
		$num_pending = connection::countReg("galeria_fotos"," AND estado=0 ");
		$num_pending = ($num_pending > 0 ? '<span class="label label-warning">'.$num_pending.'</span>' : $num_pending);
		return array( array("LabelSection" => strTranslate("Photos"),
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
}
?>