<?php
$base_dir = str_replace('modules/shop/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/shop/classes/class.shop.php");

session::ValidateSessionAjax();

if (isset($_REQUEST['id_usuario']) and $_REQUEST['id_usuario'] != ""){
	$shop = new shop();
	//VERIFICAR USUARIO EXISTE
	if (connection::countReg("users", " AND username='". $_REQUEST['id_usuario']."' ") == 0){
		ErrorMsg('el usuario <b>'.$_REQUEST['id_usuario'].'</b> no existe');
	}
	else {
		if ($shop->sumarCreditos($_REQUEST['id_usuario'], $_REQUEST['num'], $_REQUEST['motivo'], $_REQUEST['detalle']) == true)
			OkMsg($_REQUEST['num']." ".strTranslate("APP_Credits")." asignados correctamente al usuario ".$_REQUEST['id_usuario']);
	}
}
?>