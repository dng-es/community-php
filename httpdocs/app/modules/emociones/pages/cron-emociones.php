<?php
//TODO: cambiar $base_dir en el servidor de producción en función de donde se ponga este fichero (cron-emociones.php)
$base_dir = str_replace('modules/emociones/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");

//OBTENER USUARIOS A LOS QUE HAY QUE ENVIAR EMAL
$users = new users();
$mensajes = $users->getUsers(" AND  confirmed=1 AND disabled=0 "); 
if (count($mensajes)>0){
	pasadaProccess($mensajes);
}

function pasadaProccess($mensajes){
	global $ini_conf;

	$message_subject = "Pon tu emoción";
	$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
	

	foreach($mensajes as $usuario):
		$message_body_user ='
¡Muchas gracias por tu participación en los Talleres de Gestión del Estrés!<br />
En ellos hemos descubierto claves para mejorar nuestro estado de ánimo.<br />
Queremos ayudarte a recordar lo que trabajamos juntos y por eso, cada vez que entres en <a href="'.$ini_conf['SiteUrl'].'">'.$ini_conf['SiteUrl'].'</a> y registres tu emoción, te daremos un consejo relacionado con las diferentes técnicas que vivimos en el Taller sobre el estado escogido.<br />
<br />
Recuerda tus datos de acceso: <br />
usuario: '.$usuario['username'].'<br />
contraseña: '.$usuario['user_password'].'
<br />
	';
		if (messageProcess($message_subject, $message_from, $usuario['email'] , $message_body_user, null, 'smtp')){
			echo "Mensaje enviado a ".$usuario['email']."(".date("d-m-Y").")\n";
		}
	endforeach;	
}
?>