<?php

$base_dir = str_replace('modules/mailing/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/mailing/class.mailing.php");
include_once($base_dir . "modules/mailing/templates/emailfooter.php");
include_once($base_dir . "modules/users/class.users.php");
session::ValidateSessionAjax();

//VERIFICAR CÓDIGO DE TIENDA
if (isset($_POST['asunto_message']) and $_POST['asunto_message']!=""){
	pasadaProccess();
}

function pasadaProccess(){
	global $ini_conf;
	//obtener parametros de envio
	$mailing = new mailing();

	//obtener datos del mesaje
	$message_subject = $_POST['asunto_message'];
	$message_body = $_POST['texto_message'];
	$message_footer = footerMail($_SESSION['user_name']);
	$message_from = array($_POST['email_message'] => $_POST['nombre_message']);
	//$message_attachment = ($_FILES['nombre-fichero'] != "" ? $ini_conf['SiteUrl']."/".PATH_MAILING.'attachments/'.$_FILES['nombre-fichero'] : "");
	$message_attachment = "";




	//datos de la plantilla
	$html_content = $mailing->getTemplates(" AND id_template=".$_POST['template_message']);

	$user_direccion = "";
	if (isset($_POST['calle_direccion']) and $_POST['calle_direccion']!=""){ $user_direccion .= $_POST['calle_direccion'];}
	if (isset($_POST['postal_direccion']) and $_POST['postal_direccion']!=""){ $user_direccion .= " - ".$_POST['postal_direccion'];}
	if (isset($_POST['poblacion_direccion']) and $_POST['poblacion_direccion']!=""){ $user_direccion .= " - ".$_POST['poblacion_direccion'];}
	if (isset($_POST['provincia_direccion']) and $_POST['provincia_direccion']!=""){ $user_direccion .= " - ".$_POST['provincia_direccion'];}
	if (isset($_POST['telefono_direccion']) and $_POST['telefono_direccion']!=""){ $user_direccion .= "<br />Tlf.:  ".$_POST['telefono_direccion'];}
	if (isset($_POST['web_direccion']) and $_POST['web_direccion']!=""){ $user_direccion .= "<br />".$_POST['web_direccion'];}
	if (isset($_POST['email_message']) and $_POST['email_message']!=""){ $user_direccion .= "<br />".$_POST['email_message'];}

	$content = $html_content[0]['template_body'];
	$content = str_replace('[USER_DIRECCION]', $user_direccion, $content);
	$content = str_replace('[USER_EMPRESA]', $_SESSION['user_empresa'], $content);
	$content = str_replace('[USER_LOGO]', '<img src="'.$ini_conf['SiteUrl'].'/images/usuarios/'.$_SESSION['user_foto'].'" />', $content);
	if (isset($_POST['claim_promocion']) and $_POST['claim_promocion']!=""){ $content = str_replace('[CLAIM_PROMOCION]', $_POST['claim_promocion'], $content);}
	if (isset($_POST['descuento_promocion']) and $_POST['descuento_promocion']!=""){ $content = str_replace('[DESCUENTO_PROMOCION]', $_POST['descuento_promocion'], $content);}
	if (isset($_POST['date_promocion']) and $_POST['date_promocion']!=""){ $content = str_replace('[DATE_PROMOCION]', $_POST['date_promocion'], $content);}

	$message_body = $content;

	echo $message_body;
			

	//obtener usuarios a los que hay que enviar el mensaje
	// $users = new users();
	// $usuarios_envio = explode(",", $_POST['email_test']);
	// $usuarios_envio = implode("','", $usuarios_envio);
	// $usuarios_envio = "'".str_replace(" ", "", $usuarios_envio)."'";
	// $usuarios = $users->getUsers(" AND u.username IN (".$usuarios_envio.")");

	// foreach($usuarios as $usuario):
	// 	$message_to = array($usuario['email']);
	// 	$message_body_user = str_replace('[USER_USERNAME]', $usuario['username'], $message_body);
	// 	$message_body_user = str_replace('[USER_NAME]', $usuario['name'], $message_body_user);
	// 	$message_body_user = str_replace('[USER_SURNAME]', $usuario['surname'], $message_body_user);
	// 	$message_body_user = str_replace('[USER_TIENDA]', $usuario['nombre_tienda'], $message_body_user);
	// 	$message_body_user .= '<p>Si no desea recibir más emails piche <a href="'.$ini_conf['SiteUrl'].'/?page=unsuscribe&u='.$usuario['email'].'&ua='.sha1($usuario['email']).'">aquí</a></p>';
	// 	messageProcess($message_subject, $message_from, $message_to , $message_body_user, $message_attachment);
	// endforeach;

}
?>