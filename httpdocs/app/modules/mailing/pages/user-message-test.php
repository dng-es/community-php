<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/mailing/pages' : 'modules\\mailing\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/mailing/classes/class.mailing.php");
include_once($base_dir . "modules/mailing/controllers/controller.default.php");
include_once($base_dir . "modules/mailing/templates/emailfooter.php");
include_once($base_dir . "modules/users/classes/class.users.php");
session::ValidateSessionAjax();

//VERIFICAR CÓDIGO DE TIENDA
if (isset($_POST['asunto_message']) && $_POST['asunto_message']!="") pasadaProccess();

function pasadaProccess(){
	global $ini_conf;
	//obtener parametros de envio
	$mailing = new mailing();

	//obtener datos del mesaje
	$message_subject = sanitizeInput($_POST['asunto_message']);
	$message_from = array($_POST['email_message'] => $_POST['nombre_message']);
	//$message_attachment = ($_FILES['nombre-fichero'] != "" ? $ini_conf['SiteUrl']."/".PATH_MAILING.'attachments/'.$_FILES['nombre-fichero'] : "");
	$message_attachment = "";
	$message_body = mailingController::createMsgBodyAction();

	//obtener usuarios a los que hay que enviar el mensaje
	$users = new users();
	$usuarios_envio = explode(",", $_POST['email_test']);

	foreach($usuarios_envio as $usuario):
		$message_to = array(trim($usuario));
		$message_body_user = $message_body;
		// $message_body_user = str_replace('[USER_USERNAME]', $usuario['username'], $message_body);
		// $message_body_user = str_replace('[USER_NAME]', $usuario['name'], $message_body_user);
		// $message_body_user = str_replace('[USER_SURNAME]', $usuario['surname'], $message_body_user);
		// $message_body_user = str_replace('[USER_TIENDA]', $usuario['nombre_tienda'], $message_body_user);
		$message_body_user .= footerMail($usuario);
		messageProcess($message_subject, $message_from, $message_to , $message_body_user, $message_attachment);
	endforeach;
}
?>