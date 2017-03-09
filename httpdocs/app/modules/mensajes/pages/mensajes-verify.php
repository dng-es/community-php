<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/mensajes/pages' : 'modules\\mensajes\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir."core/class.connection.php");
include_once($base_dir."modules/configuration/classes/class.configuration.php");
include_once($base_dir."core/functions.core.php");
include_once($base_dir."core/constants.php");
include_once($base_dir."core/class.session.php");
session::ValidateSessionAjax();

if (isset($_REQUEST['nick']) && $_REQUEST['nick'] != ""){
	$encontrado = connection::countReg("users", " AND nick='".sanitizeInput($_REQUEST['nick'])."' ");
	echo $encontrado;
}
?>