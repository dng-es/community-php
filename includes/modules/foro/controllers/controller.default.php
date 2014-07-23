<?php
class foroController{
	public static function createAction(){
		
	}

	public static function updateAction(){

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
}
?>