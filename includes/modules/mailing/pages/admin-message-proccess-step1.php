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
if (isset($_POST['id_message']) and $_POST['id_message']!=""){
	$id_message = $_POST['id_message'];
	$action = $_POST['action'];
	$pasada = $_POST['pasada'];
	pasadaProccess($id_message, $action, $pasada);
}

function pasadaProccess($id_message, $action, $pasada){
	global $ini_conf;
	//obtener parametros de envio
	$mailing = new mailing();
	$msgs_block = $mailing->getMsgsBlock();

	//obtener datos del mesaje
	$elements=$mailing->getMessages(" AND id_message=".$id_message." "); 	
	$message_subject = $elements[0]['message_subject'];
	$message_body = $elements[0]['message_body'];
	$message_body2 = $elements[0]['message_body2'];
	$message_footer = footerMail($elements[0]['username_add']);
	$message_from = array($elements[0]['message_from_email'] => $elements[0]['message_from_name']);
	$message_attachment = ($elements[0]['message_attachment'] != "" ? $ini_conf['SiteUrl']."/".PATH_MAILING.'attachments/'.$elements[0]['message_attachment'] : "");

	//obteber datos del template
	$template = $mailing->getTemplates(" AND id_template=".$elements[0]['id_template']." ");
	$cuerpo = $template[0]['template_body'];
	$cuerpo = str_replace('[CONTENT]', $message_body, $cuerpo);
	$cuerpo = str_replace('[CONTENT2]', $message_body2, $cuerpo);
	$cuerpo = str_replace('[FOOTER]', $message_footer, $cuerpo);
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
		$message_body_user .= '<img src="'.$ini_conf['SiteUrl'].'/includes/modules/mailing/pages/ut.php?u='.$usuario['id_message_user'].'" />';
		$message_body_user .= '<p>Si no desea recibir más emails piche <a href="'.$ini_conf['SiteUrl'].'/?page=unsuscribe&u='.$usuario['email_message'].'&ua='.sha1($usuario['email_message']).'">aquí</a></p>';
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

	if ($pendientes==0){
		//actualizar datos del mensaje
		$mailing->updateMessageField($id_message, "message_status", "'completed'");
	}
	else{
		echo "<br />Esperado iniciar siguiente pasada...";	
	}	
}
?>