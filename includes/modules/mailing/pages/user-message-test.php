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
	$message_body2 = (isset($_POST['texto2_message']) ? $_POST['texto2_message'] : "");
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
	if (isset($_POST['email_message']) and $_POST['email_message']!=""){ $user_direccion .= "<br />".$_POST['email_message'];}
	if (isset($_POST['web_direccion']) and $_POST['web_direccion']!=""){ $user_direccion .= "<br />".$_POST['web_direccion'];}

	$user_redes = "";
	if (isset($_POST['red1']) and $_POST['red1']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red1'].'" />';}
	if (isset($_POST['red2']) and $_POST['red2']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red2'].'" />';}
	if (isset($_POST['red3']) and $_POST['red3']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red3'].'" />';}
	if (isset($_POST['red4']) and $_POST['red4']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red4'].'" />';}
	if (isset($_POST['red5']) and $_POST['red5']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red5'].'" />';}
	if (isset($_POST['red6']) and $_POST['red6']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red6'].'" />';}
	if (isset($_POST['red7']) and $_POST['red7']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red7'].'" />';}
	if (isset($_POST['red8']) and $_POST['red8']!=""){$user_redes .= '<img src="'.$ini_conf['SiteUrl'].'/images/redes/'.$_POST['red8'].'" />';}

	$user_opticas = "";
	$users = new users();		
	$list_tiendas = $users->getTiendas("AND id_user='".$_SESSION['user_name']."'");
	if (isset($list_tiendas) && count($list_tiendas)>1){
		foreach($list_tiendas as $tienda):
			if ($_SESSION['cod_tienda']<>$tienda['cod_tienda']){
				$optica = 'optica_'.$tienda['cod_tienda'];
				if (isset($_POST[$optica]) and $_POST[$optica]!=""){$user_opticas .= $tienda['nombre_tienda'].'<br />'.$tienda['direccion'].'<br />('.$tienda['codigo_postal'].') '.$tienda['ciudad'].' - '.$tienda['provincia'].'<br />';}
			}
		endforeach;
	}

	$content = $html_content[0]['template_body'];
	$content = str_replace('[USER_DIRECCION]', $user_direccion, $content);
	$content = str_replace('[USER_EMPRESA]',  $_POST['nombre_optica'], $content);
	$content = str_replace('[USER_LOGO]', '<img src="'.$ini_conf['SiteUrl'].'/images/usuarios/'.$_SESSION['user_foto'].'" />', $content);
	$content = str_replace('[USER_REDES]', $user_redes, $content);
	$content = str_replace('[USER_OPTICAS]', $user_opticas, $content);

	if (isset($_POST['claim_promocion']) and $_POST['claim_promocion']!=""){ $content = str_replace('[CLAIM_PROMOCION]', $_POST['claim_promocion'], $content);}
	if (isset($_POST['descuento_promocion']) and $_POST['descuento_promocion']!=""){ $content = str_replace('[DESCUENTO_PROMOCION]', $_POST['descuento_promocion'], $content);}
	if (isset($_POST['date_promocion']) and $_POST['date_promocion']!=""){ $content = str_replace('[DATE_PROMOCION]', $_POST['date_promocion'], $content);}
	
	$message_body = $content;

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
		$message_body_user .= '<p>Si no desea recibir más emails piche <a href="'.$ini_conf['SiteUrl'].'/?page=unsuscribe&u='.trim($usuario).'&ua='.sha1(trim($usuario)).'">aquí</a></p>';
		messageProcess($message_subject, $message_from, $message_to , $message_body_user, $message_attachment);
	endforeach;

}
?>