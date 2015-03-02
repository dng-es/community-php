<?php
class foroController{
	public static function getListTemasAction($reg = 0, $filtro=""){
		$foro = new foro();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("foro_temas",$filtro); 
		return array('items' => $foro->getTemas($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getItemTemaAction($id){
		$foro = new foro();
		return $foro->getTemas(" AND id_tema=".$id." ");
	}

	public static function getLastTemasAction($limit = 3, $filter=""){
		$foro = new foro();
		$filter .= ($_SESSION['user_canal']!='admin' ? " AND t.canal='".$_SESSION['user_canal']."' " : "");
		return $foro->getLastTemas($filter, $limit);
	}	

	public static function insertCommentAction(){
		if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!="" and ($_POST['id_tema']!="" or $_POST['id_tema']!=0)){
			$foro = new foro();
			$texto_comentario = nl2br(sanitizeInput($_POST['texto-comentario']));
			if ($foro->InsertComentario($_POST['id_tema'],
								$texto_comentario,
								$_SESSION['user_name'],
								ESTADO_COMENTARIOS_FORO)){
			session::setFlashMessage( 'actions_message', strTranslate("Message_published"), "alert alert-success");
			} 
			else{ session::setFlashMessage( 'actions_message', strTranslate("Error_message_published"), "alert alert-danger");}    
			redirectURL($_SERVER['REQUEST_URI']);
		} 
	}

	public static function accesoForoAreaAction($id_area){
		$acceso=1;
		if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){
			$acceso = connection::countReg("na_areas_users"," AND id_area=".$id_area." AND username_area='".$_SESSION['user_name']."' ");
		}
		return $acceso;
	}
	public static function getListComentariosAction($reg = 0, $filtro=""){
		$foro = new foro();
		$find_reg = "";
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("foro_comentarios",$filtro); 
		return array('items' => $foro->getComentarios($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function cancelComentarioAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='foro_ko'){
			$foro = new foro(); 
			$users = new users();
			$foro->cambiarEstado($_REQUEST['id'],2);
			$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario cancelado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-foro-comentarios?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}		
	}


	public static function validateComentarioAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='foro_ok'){
			$foro = new foro(); 
			$users = new users();
			$foro->cambiarEstado($_REQUEST['id'],1);
			$users->sumarPuntos($_REQUEST['u'],PUNTOS_FORO,PUNTOS_FORO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario validado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-foro-comentarios?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}
	}

	public static function changeTipoAction(){
		if (isset($_POST['find_tipo'])) { 	 
			$foro->cambiarTipoTema($_POST['id_tema_tipo'],$_POST['find_tipo']);
			session::setFlashMessage( 'actions_message', "Tema modificado correctamente.", "alert alert-success");
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function cancelTemaAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='tema_ko') { 	 
			$foro = new foro();
			$foro->cambiarEstadoTema($_REQUEST['id'],0);
			session::setFlashMessage( 'actions_message', "Tema cancelado correctamente.", "alert alert-success");
			redirectURL("admin-validacion-foro-temas?pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1)); 
		}		
	}

	public static function exportTemasAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$foro = new foro(); 
			$elements_exp=$foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['id']." ");
			$file_name='exported_file'.date("YmdGis");
			download_send_headers("comments_" . date("Y-m-d") . ".csv");
			echo array2csv($elements_exp);
			die();
		}		
	}

	public static function createRespuestaAction(){
		if (isset($_POST['comment-reply-txt']) and $_POST['comment-reply-txt']!="" and ($_POST['comment-reply-id']!="" or $_POST['comment-reply-id']!=0)){
			$foro = new foro();
			$texto_comentario = nl2br(sanitizeInput($_POST['comment-reply-txt']));
			if ($foro->InsertComentario($_POST['id_tema'],
								$texto_comentario,
								$_SESSION['user_name'],
								ESTADO_COMENTARIOS_FORO,
								$_POST['comment-reply-id'])){
				session::setFlashMessage( 'actions_message', strTranslate("Reply_publihed"), "alert alert-success");
			} 
			else{ session::setFlashMessage( 'actions_message', "Se ha producido un error en la inserción de la respuesta. Por favor, inténtalo más tarde.", "alert alert-danger");}    
			redirectURL($_SERVER['REQUEST_URI']);
		} 		
	}

	public static function votarAction(){
		//VOTAR COMENTARIO
		if (isset($_REQUEST['idvf']) and $_REQUEST['idvf']!="") { 
			$foro = new foro();
			$page_num = isset($_GET['pag']) ? $_GET['pag'] : "";
			$resultado = $foro->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);
			if ($resultado==0)
				session::setFlashMessage( 'actions_message', strTranslate("Forum_comment_vote_ok"), "alert alert-success");
			elseif ($resultado==1)
				session::setFlashMessage( 'actions_message', strTranslate("Forum_comment_vote_repeat"), "alert alert-warning");
			elseif ($resultado==2)
				session::setFlashMessage( 'actions_message', strTranslate("Forum_vote_own"), "alert alert-warning");
			redirectURL($_GET['page']."?id=".$_GET['id']."&pag=".$page_num);
		}
	}		
}
?>