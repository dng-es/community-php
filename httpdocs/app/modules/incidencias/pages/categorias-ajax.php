<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/incidencias/pages' : 'modules\\incidencias\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.incidencias.php");

session::ValidateSessionAjax();

if (isset($_POST['opt']) and $_POST['opt'] == 'categorias'){
	$incidencias = new incidencias();
	$elements = $incidencias->getCategorias("");
	$json_elements = "[";
	foreach ($elements as $element):
		$json_elements .= '"'.$element['categoria'].'",';
	endforeach;
	$json_elements = substr($json_elements, 0, -1);
	$json_elements .= "]";
	echo $json_elements;
}

?>