<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/mailing/pages' : 'modules\\mailing\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.php");
include_once($base_dir . "modules/mailing/classes/class.mailing.php");
include_once($base_dir . "modules/mailing/templates/emailfooter.php");
include_once($base_dir . "modules/users/classes/class.users.php");

//OBTENER MENSAJES PROGRAMADOS
$mailing = new mailing();
$mensajes = $mailing->getListsUsersData(" AND  (DAY(birthday)=DAY(NOW()) AND MONTH(birthday)=MONTH(NOW()) ) ");
if (count($mensajes) > 0){
	pasadaProccess($mensajes);
}

function pasadaProccess($mensajes){
	global $ini_conf;
	//obtener parametros de envio
	$mailing = new mailing();

	$message_subject = "Felicidades!!";
	$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
	$message_body_user =" Desde ".$ini_conf['SiteName']. " queremos felicitarte por tu cumple. <h4>Muchas Felicidades</h4>";

	foreach($mensajes as $usuario):
		if (messageProcess($message_subject, $message_from, $usuario['email'] , $message_body_user, null)){
			echo "Mensaje enviado a ".$usuario['email']."(".date("d-m-Y").")\n";
		}
	endforeach;
}
?>