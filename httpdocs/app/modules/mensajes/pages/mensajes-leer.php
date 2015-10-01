<?php
$base_dir = str_replace('modules/mensajes/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/mensajes/classes/class.mensajes.php");
session::ValidateSessionAjax();

if (isset($_REQUEST['id']) and $_REQUEST['id'] != "")
{
	$mensajes = new mensajes();
	$mensajes->leerMensaje($_REQUEST['id']);
}
?>
