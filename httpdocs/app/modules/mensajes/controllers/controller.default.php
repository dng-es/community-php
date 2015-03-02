<?php
class mensajesController{
	public static function createAction(){
		if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!=""){
			$mensajes = new mensajes();
			$respuesta = $mensajes->InsertMensaje($_SESSION['user_nick'],
																 $_SESSION['user_name'],
																 $_SESSION['user_mail'],
																 $_POST['nick-comentario'],
																 $_POST['asunto-comentario'],
																 $_POST['texto-comentario']);													 
			if ($respuesta==0){
				session::setFlashMessage( 'actions_message', strTranslate("Mailing_sent_ok"), "alert alert-success");

			}
			elseif ($respuesta==2){session::setFlashMessage( 'actions_message', "No se encuentra el destinatario ".$_POST['nick-comentario'].".", "alert alert-danger");}
			elseif ($respuesta==3){session::setFlashMessage( 'actions_message', strTranslate("Mailing_sent_yourself"), "alert alert-danger");}
			else { session::setFlashMessage( 'actions_message', strTranslate("Error"), "alert alert-danger");}
			redirectURL($_SERVER['REQUEST_URI']);
		}		
	}

	public static function createNickAction(){
		if (isset($_REQUEST['n']) and $_REQUEST['n']!=''){
			echo '
			<script>
			$(document).ready(function(){	
				$("#nick-comentario").val("'.$_REQUEST['n'].'");
				$("#new_mensaje").modal();
			});
			</script>';
		}
	}	

	public static function deleteRecibidoAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='ko'){
			self::deleteUserAction($_REQUEST['id'], 'user_destinatario');
			redirectURL("mensajes");
		}
	}

	public static function deleteEnviadoAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act']=='ko'){
			self::deleteUserAction($_REQUEST['id'], 'user_remitente');
			redirectURL("sent-items");
		}
	}		

	public static function deleteUserAction($id, $user_type){
		if (self::verifyOwner($id, $user_type)) self::deleteAction($id, $user_type);
		else session::setFlashMessage( 'actions_message', strTranslate("Error"), "alert alert-danger");
	}

	public static function deleteAction($id, $user_type){
		$mensajes = new mensajes();
		$function_delete = ($user_type=='user_destinatario' ? "deleteMensajeRecibido": "deleteMensajeEnviado");
		if ($mensajes->$function_delete($id)){
			session::setFlashMessage( 'actions_message', strTranslate("Mailing_delete_ok"), "alert alert-success");
		}
		else{
			session::setFlashMessage( 'actions_message', strTranslate("Error"), "alert alert-danger");
		}
	}

	/**
	 * Verifica que un mensaje sea del propietario de la sesion
	 * @param  	int 		$id 			Id del mensaje a eliminar
	 * @param  	string 		$user_type 		Remitente o destinatario
	 * @return 	boolean           			Resultado de la verificacion
	 */
	public static function verifyOwner($id, $user_type='user_destinatario'){
		$mensajes = new mensajes();
	  	$mensaje_data = $mensajes->getMensajes(" AND id_mensaje=".$id." ");
	  	return ($mensaje_data[0][$user_type]==$_SESSION['user_name']);
	}
}
?>