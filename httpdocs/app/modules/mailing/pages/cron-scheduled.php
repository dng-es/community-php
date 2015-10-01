<?php
// dormir durante 10 segundos
sleep(10);

$base_dir = str_replace('modules/mailing/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.php");
include_once($base_dir . "modules/mailing/classes/class.mailing.php");
include_once($base_dir . "modules/mailing/templates/emailfooter.php");
include_once($base_dir . "modules/users/classes/class.users.php");

//OBTENER MENSAJES PROGRAMADOS
$mailing = new mailing();
$mensajes = $mailing->getMessages(" AND (date_scheduled<>'NULL()' AND date_scheduled<=NOW())  AND message_status='pending' "); 
if (count($mensajes)>0){
	$id_message = $mensajes[0]['id_message'];
	$action = "pending";
	$pasada = 1;
	pasadaProccess($id_message, $action, $pasada);
	header ("Location: ".$_SERVER['REQUEST_URI']);
}


function pasadaProccess($id_message, $action, $pasada){
	global $ini_conf;
	//obtener parametros de envio
	$mailing = new mailing();
	$msgs_block = $mailing->getMsgsBlock();

	//obtener datos del mesaje
	$elements = $mailing->getMessages(" AND id_message=".$id_message." "); 	
	$message_subject = $elements[0]['message_subject'];
	$message_body = $elements[0]['message_body'];
	$message_from = array($elements[0]['message_from_email'] => $elements[0]['message_from_name']);
	$message_attachment = ($elements[0]['message_attachment'] != "" ? $ini_conf['SiteUrl']."/".PATH_MAILING.'attachments/'.$elements[0]['message_attachment'] : "");

	//obteber datos del template
	$template = $mailing->getTemplates(" AND id_template=".$elements[0]['id_template']." ");
	$cuerpo = $template[0]['template_body'];
	$cuerpo = str_replace('[CONTENT]', $message_body, $cuerpo);
	$message_body = $cuerpo;

	//obtener usuarios a los que hay que enviar el mensaje
	$usuarios = $mailing->getMessagesUsers(" AND id_message=".$id_message." 
											 AND (message_status='".$action."' OR message_status='pending') 
											 ORDER BY date_send ASC, id_message_user 
											 LIMIT ".$msgs_block);

	$enviados = 0;
	$fallidos = 0;

	echo '<br />Procesando la pasada '.$pasada."... ";

	foreach($usuarios as $usuario):
		$message_to = array($usuario['email_message']);
		$message_body_user = str_replace('[USER_USERNAME]', $usuario['username_message'], $message_body);
		$message_body_user = str_replace('[USER_NAME]', $usuario['name'], $message_body_user);
		$message_body_user = str_replace('[USER_SURNAME]', $usuario['surname'], $message_body_user);
		$message_body_user = str_replace('[USER_TIENDA]', $usuario['nombre_tienda'], $message_body_user);
		$message_body_user .= footerMail($usuario);
		if (messageProcess($message_subject, $message_from, $message_to , $message_body_user, $message_attachment)):
			$mailing->updateMessageUser($usuario['id_message_user'],'send');
			$enviados++;
		else:
			$mailing->updateMessageUser($usuario['id_message_user'],'failed');
			$fallidos++;
		endif;
	endforeach;


	//mensaje final
	echo "Finalizada la pasada ".$pasada.". Mensajes enviados: ".$enviados;
	echo " - Mensajes fallidos: ".$fallidos;

	//verificar si ha acabado el envio y actualizar datos
	$pendientes = connection::countReg("mailing_messages_users"," AND id_message=".$id_message." AND message_status='pending' ");
	$enviados = connection::countReg("mailing_messages_users"," AND id_message=".$id_message." AND message_status='send' ");
	$fallidos = connection::countReg("mailing_messages_users"," AND id_message=".$id_message." AND message_status='failed' ");

	$mailing->updateMessageField($id_message, "total_send", $enviados);
	$mailing->updateMessageField($id_message, "total_pending", $pendientes);
	$mailing->updateMessageField($id_message, "total_failed", $fallidos);

	if ($pendientes == 0){
		//actualizar datos del mensaje
		$mailing->updateMessageField($id_message, "message_status", "'completed'");
	}
	else{
		echo "<br />Esperado iniciar siguiente pasada...";	
	}	
}
?>