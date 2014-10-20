<?php
$base_dir = str_replace('modules/mensajes/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
session::ValidateSessionAjax();

if (isset($_REQUEST['nick']) and $_REQUEST['nick']!="")
{
	$encontrado = connection::countReg("users", " AND nick='".$_REQUEST['nick']."' ");
	echo $encontrado;
}
?>
