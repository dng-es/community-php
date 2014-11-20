<?php
$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");

session::ValidateSessionAjax();
	
if (isset($_REQUEST['id_usuario']) and $_REQUEST['id_usuario']!=""){
	$users = new users();
	//VERIFICAR USUARIO EXISTE
	if (connection::countReg("users"," AND username='". $_REQUEST['id_usuario']."' ")==0){ 
		ErrorMsg('el usuario <b>'.$_REQUEST['id_usuario'].'</b> no existe');
	}
	else {
		if ($users->sumarPuntos($_REQUEST['id_usuario'],$_REQUEST['num'],$_REQUEST['motivo'])==true){ 
			OkMsg($_REQUEST['num']." puntos asignados correctamente al usuario ".$_REQUEST['id_usuario']);}
	}
}
?>