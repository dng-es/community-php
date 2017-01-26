<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/na_areas/pages' : 'modules\\na_areas\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/na_areas/classes/class.na_areas.php");

//ACTUALIZAR TAREA
if (isset($_POST['tarea']) and $_POST['tarea'] != ""){
	$na_areas = new na_areas();
	if ($na_areas->updateTarea(intval($_POST['tarea']), sanitizeInput($_POST['descripcion']))) echo 'ok';
	else echo 'ko';
}
?>