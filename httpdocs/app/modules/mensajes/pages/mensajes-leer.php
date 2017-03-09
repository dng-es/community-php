<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/mensajes/pages' : 'modules\\mensajes\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/mensajes/classes/class.mensajes.php");
session::ValidateSessionAjax();

if (isset($_REQUEST['id']) && $_REQUEST['id'] != ""){
	$mensajes = new mensajes();
	$mensajes->leerMensaje(intval($_REQUEST['id']));
}
?>