<?php
class coreContactController{
	public static function contactAction(){
		if (isset($_POST['subject_form'])){
			global $ini_conf;
			$usuario = usersController::getPerfilAction($_SESSION['user_name']);
			$asunto_form = sanitizeInput($_POST['subject_form']);
			$cuerpo_form = sanitizeInput($_POST['body_form']);
			$asunto = 'EMAIL DESDE '.strtoupper($ini_conf['SiteName']).': '.$asunto_form;
			$cuerpo_mensaje = $_SESSION['user_name']." (".$usuario['email'].")".' - '.strTranslate("Nick").': '.$_SESSION['user_nick'].', '.strTranslate("says").': 
			
			'.$cuerpo_form;
			if (messageProcess($asunto, array($ini_conf['MailingEmail'] => 'Contactar'), array($ini_conf['ContactEmail']), $cuerpo_mensaje, null, 'smtp')) 
				session::setFlashMessage( 'actions_message', "Tu mensaje ha sido enviado correctamente, en breve nos pondremos en contacto. Gracias por tu consulta.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', "Se ha producido un error durante el envío, Por favor inténtalo más tarde.", "alert alert-danger");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>