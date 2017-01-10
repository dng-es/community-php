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

	public static function validateAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'muro_ok'){
			$users = new users();
			$muro = new muro();
			$muro->cambiarEstado($_REQUEST['id'],1);
			$users->sumarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario validado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-muro?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}

	public static function cancelAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'muro_ko'){
			$users = new users();
			$muro = new muro();
			$muro->cambiarEstado($_REQUEST['id'],2);
			$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario cancelado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-muro?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}

	public static function createAction(){
		if (isset($_POST['texto-comentario']) and trim($_POST['texto-comentario']) != ''){
			$muro = new muro();
			if ($muro->InsertComentario($_SESSION['user_canal'], sanitizeInput(trim($_POST['texto-comentario'])), $_SESSION['user_name'], 1, sanitizeInput($_POST['tipo_muro']), '') == 1)
				session::setFlashMessage( 'actions_message', "Respuesta insertada correctamente.", "alert alert-success");
			else
				session::setFlashMessage( 'actions_message', "Se ha producido un error en la inserción de la respuesta. Por favor, inténtalo más tarde.", "alert alert-danger");

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>