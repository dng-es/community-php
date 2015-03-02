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
			redirectURL("admin-validacion-muro?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}

	public static function cancelAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='muro_ko'){
			$users = new users();
			$muro = new muro();
			$muro->cambiarEstado($_REQUEST['id'],2);
			$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario cancelado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-muro?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}	
}
?>