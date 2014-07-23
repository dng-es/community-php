<?php
class mensajesController{
	public static function createAction(){
		
	}

	public static function updateAction(){
	
	}

	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("mensajes"," AND user_remitente='".$username."' ");
		return array('Mensajes internos enviados' => $num);
	}
}
?>