<?php
/**
* @Modulo de foros
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version  1.0.2
*
*/
class foroCore{
	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("foro_comentarios", " AND user_comentario='".$username."' ");
		$num_temas = connection::countReg("foro_temas", " AND user='".$username."' ");
		$num_votaciones = connection::countReg("foro_comentarios_votaciones", " AND user_votacion='".$username."' ");
		$num_visitas = connection::countReg("foro_visitas", " AND username='".$username."' ");

		return array('Comentarios en los foros' => $num,
					'Temas creados en los foros' => $num_temas,
					'Votaciones realizadas en los foros' => $num_votaciones,
					'Visitas en los foros' => $num_visitas);
	}

	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("foro-subtemas", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("foro-subtemas", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array("LabelIcon" => "fa fa-comment",
							"LabelItem" => strTranslate("Forums"),
							"LabelUrl" => 'foro-subtemas',
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
			"PageName" => "admin-validacion-foro-temas",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Forums"),
			"LabelItem" => "Temas en los foros",
			"LabelUrl" => "admin-validacion-foro-temas",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-validacion-foro-comentarios",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Forums"),
			"LabelItem" => "Comentarios en los foros",
			"LabelUrl" => "admin-validacion-foro-comentarios",
			"LabelPos" => 2,
		)));

		return $elems;
	}

	public static function HolaHook(){
		echo "Hola soy el gancho";
	}

	public static function moduleHooks(){
		add_hook('foro-comentarios', 'sidebar', 'foroCore::HolaHook');
		add_hook('foro-comentario', 'sidebar', 'HolaHook2');
	}
}
?>