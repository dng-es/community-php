<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/users/pages' : 'modules\\users\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/users/controllers/controller.creditos.php");

if(getModuleExist("prestashop")) include_once($base_dir . "modules/prestashop/controllers/controller.credits.php");

session::ValidateSessionAjax();

if (isset($_REQUEST['id_usuario']) && $_REQUEST['id_usuario'] != ""){
	//VERIFICAR USUARIO EXISTE
	if (connection::countReg("users", " AND username='". $_REQUEST['id_usuario']."' ") == 0){
		ErrorMsg('el usuario <b>'.$_REQUEST['id_usuario'].'</b> no existe');
	}
	else {
		if (usersCreditosController::sumarCreditosAction($_REQUEST['id_usuario'], $_REQUEST['num'], $_REQUEST['motivo'], $_REQUEST['detalle']) == true)
			OkMsg($_REQUEST['num']." ".strTranslate("APP_Credits")." asignados correctamente al usuario ".$_REQUEST['id_usuario']);
	}
}
?>