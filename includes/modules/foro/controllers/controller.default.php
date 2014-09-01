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
			redirectURL("?page=admin-validacion-foro-comentarios&pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
		}		
	}


	public static function validateComentarioAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='foro_ok'){
			$foro = new foro(); 
			$users = new users();
			$foro->cambiarEstado($_REQUEST['id'],1);
			$users->sumarPuntos($_REQUEST['u'],PUNTOS_FORO,PUNTOS_FORO_MOTIVO);
			session::setFlashMessage( 'actions_message', "Comentario validado correctamente.", "alert alert-success");
			redirectURL("?page=admin-validacion-foro-comentarios&pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1));
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
			redirectURL("?page=admin-validacion-foro-temas&pag=".(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1)); 
		}		
	}

	public static function exportTemasAction(){
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$foro = new foro(); 
			$elements_exp=$foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['id']." ");
			$file_name='exported_file'.date("YmdGis");
			exportCsv($elements_exp, "comentarios");
		}		
	}

	public static function createRespuestaAction(){
		if (isset($_POST['comment-reply-txt']) and $_POST['comment-reply-txt']!="" and ($_POST['comment-reply-id']!="" or $_POST['comment-reply-id']!=0)){
			$foro = new foro();
			if ($foro->InsertComentario($_POST['id_tema'],
								$_POST['comment-reply-txt'],
								$_SESSION['user_name'],
								ESTADO_COMENTARIOS_FORO,
								$_POST['comment-reply-id'])){
				session::setFlashMessage( 'actions_message', "Respuesta insertada correctamente.", "alert alert-success");
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
			session::setFlashMessage( 'actions_message', $foro->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']), "alert alert-success");
			redirectURL("?page=".$_GET['page']."&id=".$_GET['id']."&pag=".$page_num);
		}
	}

	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("foro_comentarios"," AND user_comentario='".$username."' ");
		$num_temas = connection::countReg("foro_temas"," AND user='".$username."' ");
		$num_votaciones = connection::countReg("foro_comentarios_votaciones"," AND user_votacion='".$username."' ");
		$num_visitas = connection::countReg("foro_visitas"," AND username='".$username."' ");

		return array('Comentarios en los foros' => $num,
					 'Temas creados en los foros' => $num_temas,
					 'Votaciones realizadas en los foros' => $num_votaciones,
					 'Visitas en los foros' => $num_visitas);	
	}	

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate('Forums'),
							"LabelItem" => 'Temas en los foros',
							"LabelUrl" => 'admin-validacion-foro-temas',
							"LabelPos" => 1),
					  array("LabelHeader"=>'Modules',
							"LabelSection"=>strTranslate('Forums'),
							"LabelItem"=>'Comentarios en los foros',
							"LabelUrl"=>'admin-validacion-foro-comentarios',
							"LabelPos" => 2));	
	}		
}
?>