<?php
class muroController{
	public static function getListAction($reg = 0, $filtro=""){
		$muro = new muro();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("muro_comentarios",$filtro); 
		return array('items' => $muro->getComentarios($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function createAction(){
		
	}

	public static function validateAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='muro_ok'){
			$users = new users();
			$muro = new muro();
			$muro->cambiarEstado($_REQUEST['id'],1);
			$users->sumarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario validado correctamente.", "alert alert-success");
			redirectURL("?page=admin-validacion-muro&pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}

	public static function cancelAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='muro_ko'){
			$users = new users();
			$muro = new muro();
			$muro->cambiarEstado($_REQUEST['id'],2);
			$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario cancelado correctamente.", "alert alert-success");
			redirectURL("?page=admin-validacion-muro&pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
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