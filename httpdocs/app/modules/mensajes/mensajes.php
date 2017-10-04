<?php
/**
* @Mensajeria interna
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 1.1
*
*/
class mensajesCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order = 0){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("inbox", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("inbox", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-envelope",
				"LabelItem" => strTranslate("Mailing_messages"),
				"LabelUrl" => 'inbox',
				"LabelTarget" => '_self',
				"LabelClass" => 'hidden-md hidden-lg',
				"LabelPos" => $menu_order));
		}
		return $array_final;
	}

	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("mensajes", " AND user_remitente='".$username."' ");
		return array('Mensajes internos enviados' => $num);
	}

	public static function messagesUser(){
		//MENSAJE NO LEIDOS
		$contador_no_leidos = connection::countReg("mensajes", " AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");
		echo '<a href="inbox" id="perfil-btn" title="'.strTranslate("Mailing_messages").'"><i class="fa fa-envelope faa-shake animated-hover"></i> <span id="contador-leidos-header">'.$contador_no_leidos.'</span></a>';
	}

	public static function moduleHooks(){
		add_hook('', 'header', 'mensajesCore::messagesUser', 1);
	}
}
?>