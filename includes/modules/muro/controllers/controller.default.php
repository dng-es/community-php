<?php
class muroController{
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
		$num = connection::countReg("muro_comentarios"," AND tipo_muro='principal' AND user_comentario='".$username."' ");
		$num_votaciones = connection::countReg("muro_comentarios_votaciones"," AND user_votacion='".$username."' ");
		return array('Comentarios en el muro' => $num,
					 'Votaciones realizadas en el muro' => $num_votaciones);
	}	
}
?>