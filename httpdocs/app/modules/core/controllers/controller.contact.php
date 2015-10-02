<?php
class coreContactController{

	public static function contactAction(){
		if (isset($_POST['subject_form'])) {
			global $ini_conf;
			$asunto = 'EMAIL DESDE '.strtoupper($ini_conf['SiteName']).': '.$_POST['subject_form'];
			$cuerpo_mensaje = $_SESSION['user_name'].' - '.strTranslate("Nick").': '.$_SESSION['user_nick'].', '.strTranslate("says").': 
			
			'.$_POST['body_form'];
			if (messageProcess($asunto, array($ini_conf['MailingEmail'] => 'Contactar'), array($ini_conf['ContactEmail']), $cuerpo_mensaje, null, 'smtp')) 
				session::setFlashMessage( 'actions_message', "Su mensaje ha sido enviado correctamente, en breve nos pondremos en contacto.<br />Gracias por tu consulta.", "alert alert-success");
			else
				session::setFlashMessage('actions_message', "Se ha producido un error durante el envío, Por favor inténtalo más tarde.", "alert alert-danger");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>